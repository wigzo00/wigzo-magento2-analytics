## Wigzo Magento 2 Service

Wigzo provides Ecommerce Reporting with Actionable Insights.  Use historical data to uncover your most profitable merchandise, channels, and customer segments.

## Installation

Before installing, it is recommended that you disable your cache in System -> Cache Mangement.

#### Update composer.json
To install, you'll need to be sure that your root `composer.json` file contains a reference to the Wigzo repository.  To do so, add the following to `composer.json`:

```json
    "repositories": [
        {
            "type": "vcs",                                                                                                              
            "url": "https://github.com/wigzo00/wigzo-magento2-analytics.git"
        }
    ]
```

The above can also be added using the Composer command line with the command:

    composer config repositories.wigzo vcs https://github.com/wigzo00/wigzo-magento2-analytics.git

Next, add the required package your root `composer.json` file:

```json
    "require": {
        "wigzo-magento2-analytics": "2.1.0"
    }
```

You can also add this using the Composer command line with the command:

    composer require wigzo00/wigzo-magento2-analytics:2.1.0

#### Run Update
From the command line, run the composer update with the command:

    composer update

#### Run setup:upgrade
From the command line, run setup:upgrade with the command:

    magento setup:upgrade

#### Run di:compile
From the command line, run di:compile with the command:

    magento setup:di:compile
