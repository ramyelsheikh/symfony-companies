# RESTing with Symfony 3.2

## Setup the Project

1. Clone the project to your Server:

```bash
git clone git@github.com:ramyelsheikh/symfony-companies.git
```

2. Make sure you have [Composer installed](https://getcomposer.org/).

3. Install the composer dependencies:

```bash
composer install
```

4. Load up your database

Make sure `app/config/parameters.yml` is correct for your database
credentials. Then:

```bash
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
```

5. Start up the built-in PHP web server:

```bash
php app/console server:run
```

Then find the site at http://localhost:8000.

## TODO List:

1. update symfony to symfony 3.4 or 4.0 to work on swagger and create Rest API documentation. 


## Notes:
While Updating Symfony and Creating Swagger Documentation, You can find API Documentation below:

Companies

1. Create Company:

   POST /companies

```
    {
      "name": "Bayzat",
      "address": "Sports City"
    }
```

2. Update Company:

   PUT /companies/{id}

```
    {
      "name": "Bayzat",
      "address": "Sports City"
    }
```

3. List Companies:

   GET /companies

4. Get Company:

   GET /companies/{id}


Employees

1. Create Employee:

   POST /employees

```
    {
      "name": "Ramy Mohamed ElSheikh",
      "phone_number": "+971 58 949 9660",
      "gender": "m",
      "date_of_birth": "1988-01-15",
      "salary": "12000.00",
      "company_id": "34"
    }
```

2. Update Employee:

   PUT /employees/{id}

```
    {
      "name": "Ramy Mohamed ElSheikh",
      "phone_number": "+971 58 949 9660",
      "gender": "m",
      "date_of_birth": "1988-01-15",
      "salary": "12000.00",
      "company_id": "34"
     }
```

3. List Employees:

   GET /employees

4. Get Employee:

   GET /employees/{id}
   
   
Dependants

1. Create Dependant:

   POST /dependants

```
    {
      "name": "Mohamed ElSheikh",
      "phone_number": "+971 58 949 9660",
      "gender": "m",
      "date_of_birth": "1988-01-15",
      "relation_id": "1",
      "employee_id": "3"
    }
```

2. Update Dependant:

   PUT /dependants/{id}

```
    {
      "name": "Mohamed ElSheikh",
      "phone_number": "+971 58 949 9660",
      "gender": "m",
      "date_of_birth": "1988-01-15",
      "relation_id": "1",
      "employee_id": "3"
    }
```

3. List Dependants:

   GET /dependants

4. Get Dependant:

   GET /dependant/{id}
   
   
Relations

1. Create Relation:

   POST /relations

```
    {
      "name": "Son"
    }
```

2. Update Relation:

   PUT /relations/{id}

```
    {
      "name": "Daughter",
    }
```

3. List Relations:

   GET /relations

4. Get Relation:

   GET /relations/{id}