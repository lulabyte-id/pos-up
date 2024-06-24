![img.png](img.png)

# POS Up!

This project is a scalable SaaS-style platform designed to assist SME business in managing their transactions efficiently. The platform is built using Laravel, a PHP framework, and utilizes the Filament package for the admin panel, Stancl/Tenancy for multi-tenancy support, and Vue.js for the client panel.

## Features

- **Multi-Tenancy:** The platform supports multi-tenancy to ensure data segregation and security between different delivery companies. Each company has its own dedicated space within the platform.

- **User Management:**
    - Users can log in, access the system, and create orders for clients.
    - Agents have the ability to create orders for delivery to their client's addresses.

- **Order Management:**
    - Represents the amount of item to be delivered to the client's address.
    - Orders are created and saved by users.

- **Modular Structure:**
    - The project is organized into modules, each focusing on specific functionalities.
    - Modules use services and repositories for efficient code organization and separation of concerns.

- **Vue.js Components:**
    - The client panel is built using Vue.js components, ensuring a smooth and responsive user experience.

- **Testing:**
    - Some modules include feature tests to ensure code quality and reliability.

- **Themes:**
    - The platform supports a multi-theme structure, providing flexibility in the visual appearance.

- **Filament Admin Panel:**
    - Utilizes Filament for the admin panel, offering a powerful and customizable interface for managing system users and entities.

## Deployment
### Development Environment (Sail Docker):

- Clone the repository:

```bash
git clone https://github.com/lulabyte-id/pos-up.git
cd pos-up
```

- Install the project dependencies using Composer:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs --no-scripts
```

- Copy the .env.example file:

```bash
cp .env.example .env
```

- Edit the .env file and configure the database and other necessary settings.

- Run the Laravel Sail containers:

```bash
./vendor/bin/sail up -d
```

- Generate the application key:

```bash
./vendor/bin/sail artisan key:generate
```

- Update the Composer dependencies (required):
```bash
./vendor/bin/sail composer update
```

- Migrate the database:

```bash
./vendor/bin/sail artisan module:migrate
./vendor/bin/sail artisan module:seed
./vendor/bin/sail artisan tenants:run module:seed
```

- Assign the role and permission to the default user:

```bash
./vendor/bin/sail artisan shield:generate --resource=RoleResource --option=permissions

./vendor/bin/sail artisan shield:super-admin

./vendor/bin/sail artisan tenants:run shield:generate --option="resource=RoleResource" --option="option=permissions"

./vendor/bin/sail artisan tenants:run shield:super-admin
```

- Install NPM dependencies and compile assets:

```bash
./vendor/bin/sail npm install && ./vendor/bin/sail npm run mars:install
```

- Run npm watch to compile assets:

```bash
./vendor/bin/sail npm run mars:dev
```
- Set domain and subdomains in the hosts file:

```bash
 127.0.0.1 posup.test
 127.0.0.1 john.posup.test
 127.0.0.1 jane.posup.test
 ```

### Panel Access

1. Landlord manager panel at http://posup.test/manager/login.
2. Tenant `John`'s panel at http://john.posup.test. 
3. Tenant `Jane`'s panel at http://jane.posup.test.
4. Tenant `John`'s agent panel at http://john.posup.test/agent/login.
5. Tenant `Jane`'s agent panel at http://jane.posup.test/agent/login.

### Default Credentials

- Admin User:
  - Username: admin@lulabyte.id
  - Password: password
- Client User:
  - Username: client@lulabyte.id
  - Password: password
- Agent User:
  - Username: agent@lulabyte.id
  - Password: password

## CI/CD:

- CI/CD are managed through GitHub Actions.
- The GitHub Actions workflow can be found in the `.github` folder.
- The workflow includes the following steps:

  1. **Test Stage:**
    - After each merge pull request, tests are automatically run to ensure code quality and reliability.
    - Any issues identified during testing will halt the deployment process.

  2. **Docker Image Creation:**
    - Upon successful testing, a Docker image is created for the latest version of the code.
    - The Dockerfile and configuration files for the staging environment are utilized during this process.

  3. **Docker Image Push:**
    - The newly created Docker image is then pushed to the Docker registry, making it accessible for deployment in production.

- This automated workflow ensures consistency, reliability, and efficiency in deploying the latest code changes to the production environment.

## Additional Information:

- **Tenancy Management:**
    - The Stancl/Tenancy package is used for efficient tenancy management, separating databases, caches, and events for each tenant.

- **Filament Admin Panel:**
    - Filament is used for the admin panel, providing a rich and extensible interface for managing system users, entities, and configurations.
    - Advantages include a customizable dashboard, user management, entity management, and a built-in role and permission system.
