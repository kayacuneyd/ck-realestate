# Agent Module

This module manages the real estate agents.

## Features

- Admin CRUD for agents
- Frontend listing of agents

## File Structure

```
Agent/
├── Config/
│   └── Routes.php
├── Controllers/
│   ├── Admin/
│   │   └── AgentController.php
│   └── Frontend/
│       └── AgentController.php
├── Models/
│   └── AgentModel.php
├── Entities/
│   └── Agent.php
├── Database/
│   ├── Migrations/
│   │   └── ...CreateAgents.php
│   └── Seeds/
│       └── AgentSeeder.php
├── Views/
│   ├── admin/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── show.php
│   └── frontend/
│       ├── index.php
│       └── show.php
├── Language/
│   ├── de/Agent.php
│   ├── en/Agent.php
│   └── tr/Agent.php
├── Helpers/
│   └── agent_helper.php
└── README.md
```
