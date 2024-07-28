# Questionnaire
Questionnaire written with symfony

## Step by step guid how to run application
1. Install docker with compose plugin
2. Free the ports 9000, 5432 and 80
3. Create .env file using ``` cp .env.example .env```
4. Run the magic command ``` docker compose up -d --build --force-recreate ```
5. Install all dependencies ``` docker compose exec symfony composer install ```
6. Migrate DB ``` docker compose exec symfony php bin/console doctrine:schema:update --force ```
7. Seed DB ``` docker compose exec symfony php bin/console doctrine:fixtures:load```
