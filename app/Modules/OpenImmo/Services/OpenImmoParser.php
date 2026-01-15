<?php

namespace App\Modules\OpenImmo\Services;

use XMLReader;
use DOMDocument;

/**
 * OpenImmo XML Parser Service
 * 
 * Streaming XML parser for OpenImmo files using XMLReader.
 * Handles large files efficiently without loading entire file into memory.
 */
class OpenImmoParser
{
    protected ?XMLReader $reader = null;
    protected array $transferInfo = [];
    protected array $provider = [];
    protected array $errors = [];
    protected ?string $sourceEncoding = null;

    /**
     * Open an OpenImmo XML file for parsing.
     */
    public function open(string $xmlPath): bool
    {
        if (!file_exists($xmlPath)) {
            $this->errors[] = "XML file not found: {$xmlPath}";
            return false;
        }

        // Detect encoding from XML declaration
        $this->detectEncoding($xmlPath);

        $this->reader = new XMLReader();
        if (!$this->reader->open($xmlPath)) {
            $this->errors[] = "Failed to open XML file: {$xmlPath}";
            return false;
        }

        // Parse header information
        $this->parseHeader();

        return true;
    }

    /**
     * Detect file encoding from XML declaration.
     */
    protected function detectEncoding(string $xmlPath): void
    {
        $handle = fopen($xmlPath, 'r');
        $header = fread($handle, 200);
        fclose($handle);

        if (preg_match('/encoding=["\']([^"\']+)["\']/i', $header, $matches)) {
            $this->sourceEncoding = strtoupper($matches[1]);
        } else {
            $this->sourceEncoding = 'UTF-8';
        }
    }

    /**
     * Parse transfer and provider information from header.
     */
    protected function parseHeader(): void
    {
        while ($this->reader->read()) {
            if ($this->reader->nodeType !== XMLReader::ELEMENT) {
                continue;
            }

            switch ($this->reader->name) {
                case 'uebertragung':
                    $this->transferInfo = [
                        'art' => $this->reader->getAttribute('art'),
                        'umfang' => $this->reader->getAttribute('umfang'),
                        'modus' => $this->reader->getAttribute('modus'),
                        'version' => $this->reader->getAttribute('version'),
                        'timestamp' => $this->reader->getAttribute('timestamp'),
                    ];
                    break;

                case 'anbieter':
                    // Parse provider info from inner XML
                    $this->parseProvider();
                    return; // Stop here, properties come next
            }
        }
    }

    /**
     * Parse provider (anbieter) information.
     */
    protected function parseProvider(): void
    {
        $depth = $this->reader->depth;

        while ($this->reader->read()) {
            if (
                $this->reader->nodeType === XMLReader::END_ELEMENT &&
                $this->reader->name === 'anbieter'
            ) {
                break;
            }

            if ($this->reader->nodeType !== XMLReader::ELEMENT) {
                continue;
            }

            switch ($this->reader->name) {
                case 'anbieternr':
                    $this->provider['id'] = $this->getElementText();
                    break;
                case 'firma':
                    $this->provider['company'] = $this->convertEncoding($this->getElementText());
                    break;
                case 'immobilie':
                    // We've hit the first property, stop parsing provider
                    return;
            }
        }
    }

    /**
     * Iterate through properties (immobilie elements).
     * 
     * @return \Generator Yields property arrays one at a time
     */
    public function getProperties(): \Generator
    {
        // Reset reader to beginning and skip to first immobilie
        if ($this->reader === null) {
            return;
        }

        // Continue reading from current position or find first immobilie
        do {
            if (
                $this->reader->nodeType === XMLReader::ELEMENT &&
                $this->reader->name === 'immobilie'
            ) {
                yield $this->parseProperty();
            }
        } while ($this->reader->read());
    }

    /**
     * Parse a single property element.
     */
    protected function parseProperty(): array
    {
        $property = [
            'external_id' => null,
            'action' => 'INSERT', // Default action
            'title' => null,
            'description' => null,
            'marketing_type' => null,
            'property_type' => null,
            'price' => null,
            'cold_rent' => null,
            'warm_rent' => null,
            'additional_costs' => null,
            'heating_costs' => null,
            'deposit' => null,
            'commission' => null,
            'rooms' => null,
            'bedrooms' => null,
            'bathrooms' => null,
            'living_area' => null,
            'usable_area' => null,
            'plot_area' => null,
            'address' => null,
            'city' => null,
            'zip_code' => null,
            'latitude' => null,
            'longitude' => null,
            'floor' => null,
            'total_floors' => null,
            'construction_year' => null,
            'heating_type' => null,
            'energy_certificate_type' => null,
            'energy_value' => null,
            'energy_class' => null,
            'available_from' => null,
            'images' => [],
            'main_image' => null,
        ];

        // Get action attribute if present
        if ($this->reader->getAttribute('action')) {
            $property['action'] = strtoupper($this->reader->getAttribute('action'));
        }

        // Parse inner XML as DOM for easier navigation
        $innerXml = $this->reader->readOuterXml();
        $doc = new DOMDocument();
        @$doc->loadXML($innerXml);

        // verwaltung_techn - technical management data
        $this->parseVerwaltungTechn($doc, $property);

        // objektkategorie - property category
        $this->parseObjektkategorie($doc, $property);

        // geo - location data
        $this->parseGeo($doc, $property);

        // kontaktperson - contact person (skip for now)

        // preise - prices
        $this->parsePreise($doc, $property);

        // flaechen - areas
        $this->parseFlaechen($doc, $property);

        // ausstattung - equipment/features
        $this->parseAusstattung($doc, $property);

        // zustand_angaben - condition and energy
        $this->parseZustandAngaben($doc, $property);

        // freitexte - free texts
        $this->parseFreitexte($doc, $property);

        // anhaenge - attachments (images, documents)
        $this->parseAnhaenge($doc, $property);

        // Move reader past this immobilie element
        $this->reader->next();

        return $property;
    }

    /**
     * Parse verwaltung_techn section (technical management data).
     */
    protected function parseVerwaltungTechn(DOMDocument $doc, array &$property): void
    {
        $node = $doc->getElementsByTagName('verwaltung_techn')->item(0);
        if (!$node)
            return;

        $property['external_id'] = $this->getNodeValue($node, 'objektnr_extern');

        // Check for action in aktion element
        $aktion = $node->getElementsByTagName('aktion')->item(0);
        if ($aktion && $aktion->getAttribute('aktionart')) {
            $property['action'] = strtoupper($aktion->getAttribute('aktionart'));
        }
    }

    /**
     * Parse objektkategorie section (property category).
     */
    protected function parseObjektkategorie(DOMDocument $doc, array &$property): void
    {
        $node = $doc->getElementsByTagName('objektkategorie')->item(0);
        if (!$node)
            return;

        // Marketing type
        $vermarktungsart = $node->getElementsByTagName('vermarktungsart')->item(0);
        if ($vermarktungsart) {
            if ($vermarktungsart->getAttribute('KAUF') === 'true') {
                $property['marketing_type'] = 'KAUF';
            } elseif ($vermarktungsart->getAttribute('MIETE_PACHT') === 'true') {
                $property['marketing_type'] = 'MIETE';
            }
        }

        // Property type
        $objektart = $node->getElementsByTagName('objektart')->item(0);
        if ($objektart) {
            foreach ($objektart->childNodes as $child) {
                if ($child->nodeType === XML_ELEMENT_NODE) {
                    $property['property_type'] = $child->nodeName;
                    break;
                }
            }
        }
    }

    /**
     * Parse geo section (location data).
     */
    protected function parseGeo(DOMDocument $doc, array &$property): void
    {
        $node = $doc->getElementsByTagName('geo')->item(0);
        if (!$node)
            return;

        $property['zip_code'] = $this->getNodeValue($node, 'plz');
        $property['city'] = $this->convertEncoding($this->getNodeValue($node, 'ort'));

        $street = $this->convertEncoding($this->getNodeValue($node, 'strasse'));
        $number = $this->getNodeValue($node, 'hausnummer');
        $property['address'] = trim("{$street} {$number}");

        // Coordinates
        $coords = $node->getElementsByTagName('geokoordinaten')->item(0);
        if ($coords) {
            $property['latitude'] = (float) $coords->getAttribute('breitengrad');
            $property['longitude'] = (float) $coords->getAttribute('laengengrad');
        }

        $property['floor'] = (int) $this->getNodeValue($node, 'etage');
        $property['total_floors'] = (int) $this->getNodeValue($node, 'anzahl_etagen');
    }

    /**
     * Parse preise section (prices).
     */
    protected function parsePreise(DOMDocument $doc, array &$property): void
    {
        $node = $doc->getElementsByTagName('preise')->item(0);
        if (!$node)
            return;

        $property['price'] = (float) $this->getNodeValue($node, 'kaufpreis');
        $property['cold_rent'] = (float) $this->getNodeValue($node, 'nettokaltmiete');
        $property['warm_rent'] = (float) $this->getNodeValue($node, 'warmmiete');
        $property['additional_costs'] = (float) $this->getNodeValue($node, 'nebenkosten');
        $property['heating_costs'] = (float) $this->getNodeValue($node, 'heizkosten');
        $property['deposit'] = $this->convertEncoding($this->getNodeValue($node, 'kaution'));
        $property['commission'] = $this->convertEncoding($this->getNodeValue($node, 'courtage'));
    }

    /**
     * Parse flaechen section (areas).
     */
    protected function parseFlaechen(DOMDocument $doc, array &$property): void
    {
        $node = $doc->getElementsByTagName('flaechen')->item(0);
        if (!$node)
            return;

        $property['living_area'] = (float) $this->getNodeValue($node, 'wohnflaeche');
        $property['usable_area'] = (float) $this->getNodeValue($node, 'nutzflaeche');
        $property['plot_area'] = (float) $this->getNodeValue($node, 'grundstuecksflaeche');
        $property['rooms'] = (float) $this->getNodeValue($node, 'anzahl_zimmer');
        $property['bedrooms'] = (int) $this->getNodeValue($node, 'anzahl_schlafzimmer');
        $property['bathrooms'] = (int) $this->getNodeValue($node, 'anzahl_badezimmer');
    }

    /**
     * Parse ausstattung section (equipment/features).
     */
    protected function parseAusstattung(DOMDocument $doc, array &$property): void
    {
        $node = $doc->getElementsByTagName('ausstattung')->item(0);
        if (!$node)
            return;

        // Extract heating type
        $heizung = $node->getElementsByTagName('heizungsart')->item(0);
        if ($heizung) {
            foreach ($heizung->attributes as $attr) {
                if ($attr->value === 'true') {
                    $property['heating_type'] = $attr->name;
                    break;
                }
            }
        }
    }

    /**
     * Parse zustand_angaben section (condition and energy).
     */
    protected function parseZustandAngaben(DOMDocument $doc, array &$property): void
    {
        $node = $doc->getElementsByTagName('zustand_angaben')->item(0);
        if (!$node)
            return;

        $property['construction_year'] = (int) $this->getNodeValue($node, 'baujahr');

        // Energy certificate
        $energiepass = $node->getElementsByTagName('energiepass')->item(0);
        if ($energiepass) {
            $property['energy_certificate_type'] = $this->getNodeValue($energiepass, 'epart');
            $property['energy_value'] = (float) $this->getNodeValue($energiepass, 'energieverbrauchkennwert');

            if (!$property['energy_value']) {
                $property['energy_value'] = (float) $this->getNodeValue($energiepass, 'endenergiebedarf');
            }

            $property['energy_class'] = $this->getNodeValue($energiepass, 'effizienzklasse');
        }
    }

    /**
     * Parse freitexte section (free texts).
     */
    protected function parseFreitexte(DOMDocument $doc, array &$property): void
    {
        $node = $doc->getElementsByTagName('freitexte')->item(0);
        if (!$node)
            return;

        $property['title'] = $this->convertEncoding($this->getNodeValue($node, 'objekttitel'));
        $property['description'] = $this->convertEncoding($this->getNodeValue($node, 'objektbeschreibung'));
        $property['available_from'] = $this->convertEncoding($this->getNodeValue($node, 'verfuegbar_ab'));
    }

    /**
     * Parse anhaenge section (attachments/media).
     */
    protected function parseAnhaenge(DOMDocument $doc, array &$property): void
    {
        $node = $doc->getElementsByTagName('anhaenge')->item(0);
        if (!$node)
            return;

        $anhangs = $node->getElementsByTagName('anhang');
        foreach ($anhangs as $anhang) {
            $gruppe = $anhang->getAttribute('gruppe');
            $location = $anhang->getAttribute('location');

            // Get file path
            $daten = $anhang->getElementsByTagName('daten')->item(0);
            if (!$daten)
                continue;

            $pfad = $daten->getElementsByTagName('pfad')->item(0);
            if (!$pfad)
                continue;

            $filePath = $pfad->nodeValue;

            // Determine if this is title image
            if ($gruppe === 'TITELBILD' && !$property['main_image']) {
                $property['main_image'] = [
                    'path' => $filePath,
                    'location' => $location,
                    'gruppe' => $gruppe,
                ];
            }

            // Add to images array
            if (in_array($gruppe, ['TITELBILD', 'INNENANSICHT', 'AUSSENANSICHT', 'BILD'])) {
                $property['images'][] = [
                    'path' => $filePath,
                    'location' => $location,
                    'gruppe' => $gruppe,
                ];
            }
        }
    }

    /**
     * Get text value from a child element.
     */
    protected function getNodeValue(\DOMNode $parent, string $tagName): ?string
    {
        $nodes = $parent->getElementsByTagName($tagName);
        if ($nodes->length > 0) {
            return $nodes->item(0)->nodeValue;
        }
        return null;
    }

    /**
     * Get text content of current element.
     */
    protected function getElementText(): string
    {
        return $this->reader->readString();
    }

    /**
     * Convert string from source encoding to UTF-8.
     */
    protected function convertEncoding(?string $text): ?string
    {
        if ($text === null || $this->sourceEncoding === 'UTF-8') {
            return $text;
        }

        return mb_convert_encoding($text, 'UTF-8', $this->sourceEncoding);
    }

    /**
     * Get transfer information.
     */
    public function getTransferInfo(): array
    {
        return $this->transferInfo;
    }

    /**
     * Get provider information.
     */
    public function getProvider(): array
    {
        return $this->provider;
    }

    /**
     * Check if this is a full transfer (VOLL).
     */
    public function isFullTransfer(): bool
    {
        return ($this->transferInfo['umfang'] ?? '') === 'VOLL';
    }

    /**
     * Get any errors that occurred.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Close the reader.
     */
    public function close(): void
    {
        if ($this->reader) {
            $this->reader->close();
            $this->reader = null;
        }
    }
}
