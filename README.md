# Cradle Website Package

Common Schemas and front end for websites. Schemas included

 - Layout
   - Page - Create static or dynamic pages, trigger an event and customize the template in the admin. Pages are designed for simple request and response outputs and are designed to work in collaboration with code via events. Pages are also designed to easily set up SEO per page, build sitemaps, and RSS feeds.
   - Block - Blocks are used to handle separate logic that needs to be outputted in pages. Like pages, blocks also can trigger events and can have a customized template defined in the admin. Usage `{{{block 'block-name'}}}`.
 - Content
   - Category - General category definition that can be used with other schemas
   - File - General file repository definition that can be used with other schemas
   - Post - An article post schema, with front end support used for a general blog

## Install

This package is experimental and is still in development. To try out this package you need to manually copy the schemas to your `/[project]/config/schema` folder, install each schema one by one and run the SQL scripts in [`package/fixtures`](https://github.com/CradlePHP/cradle-website/tree/master/package/fixtures).

```
$ composer require cradlephp/cradle-website
```

 ----

 <a name="contributing"></a>
 # Contributing to Cradle PHP

 Thank you for considering to contribute to Cradle PHP.

 Please DO NOT create issues in this repository. The official issue tracker is located @ https://github.com/CradlePHP/cradle/issues . Any issues created here will *most likely* be ignored.

 Please be aware that master branch contains all edge releases of the current version. Please check the version you are working with and find the corresponding branch. For example `v1.1.1` can be in the `1.1` branch.

 Bug fixes will be reviewed as soon as possible. Minor features will also be considered, but give me time to review it and get back to you. Major features will **only** be considered on the `master` branch.

 1. Fork the Repository.
 2. Fire up your local terminal and switch to the version you would like to
 contribute to.
 3. Make your changes.
 4. Always make sure to sign-off (-s) on all commits made (git commit -s -m "Commit message")

 ## Making pull requests

 1. Please ensure to run [phpunit](https://phpunit.de/) and
 [phpcs](https://github.com/squizlabs/PHP_CodeSniffer) before making a pull request.
 2. Push your code to your remote forked version.
 3. Go back to your forked version on GitHub and submit a pull request.
 4. All pull requests will be passed to [Travis CI](https://travis-ci.org/CradlePHP/cradle-system) to be tested. Also note that [Coveralls](https://coveralls.io/github/CradlePHP/cradle-system) is also used to analyze the coverage of your contribution.
