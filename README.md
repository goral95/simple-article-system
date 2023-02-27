# simple-article-system

Project is on master branch. To run the project you should first run localhost on your computer.
First of all you should download composer dependecies by running from command prompt in direction of project this command:

```
composer install
```

Than you need to create database schema and make migrations with commands below:

```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

Last step is to run symfony local server by command:

```
symfony serve -d
```

Please find below comments to given api routes:

Route: "/create-default-authors" 
With this endpoint you add 3 hardcoded authors to database.

Route: "/authors/top3" 
API Endpoint to get top 3 authors that wrote the most articles last week.

Route: "/articles/{id}" 
API Endpoint to get article by some {id}.

Route: "/author/{authorId}/articles" 
API Endpoint to get  all articles for given {authorId}.

Route: "'/articles/create'" 
Render HTML form to create new article.

Route: "'/articles/edit/{id}'" 
Render HTML form to edit article by {id}.
