Advanced Odds Comparison WordPress Plugin
This plugin was developed as a solution for the Senior WordPress Developer assignment. It provides a complete, object-oriented solution for fetching, comparing, and displaying live odds from various bookmakers directly within WordPress.

Features
Admin Management Dashboard: A dedicated settings page under Settings > Odds Comparison allows administrators to easily manage which bookmakers and markets are displayed across the site.

Dynamic Gutenberg Block: A custom "Odds Comparison Table" block allows content creators to seamlessly embed and configure odds tables directly into posts and pages with a live preview in the editor.

Live Data Scraping & Caching: The plugin is built to scrape live odds from an external source. To ensure optimal performance and avoid rate-limiting, it uses the WordPress Transients API to cache the data, only fetching new data after a set interval.

Demo Mode: For development and testing without reliance on a live website, the plugin includes a demo scraper class that provides reliable, hardcoded data.

Odds Conversion Utility: A self-contained, static helper class (Odds_Comparison_Converter) provides robust methods to convert odds between Decimal, Fractional, and American formats.

Technical Details & Code Quality
This plugin was built with a strong focus on modern, professional WordPress development practices.

Object-Oriented Design
The plugin follows strict OOP principles to ensure the code is organized, maintainable, and scalable.

Encapsulation: Each class has a single, well-defined responsibility.

Odds_Comparison: The main plugin orchestrator.

Odds_Comparison_Loader: Manages all WordPress hooks (actions and filters).

Odds_Comparison_Admin: Handles the admin dashboard logic.

Odds_Comparison_Public: Handles front-end script/style enqueuing.

Odds_Comparison_Gutenberg: Manages the registration and rendering of the Gutenberg block.

Odds_Comparison_Scraper: Responsible for all data fetching and caching logic.

Odds_Comparison_Converter: A static utility class for odds math.

Design Patterns
Singleton-like Controller: The main plugin class is instantiated once and acts as a central controller, a common and effective pattern in WordPress.

Dependency Injection: Dependencies like the plugin name and version are passed into class constructors, making components more modular and testable.

WordPress Best Practices
Adherence to Coding Standards: The code follows PSR-2 and WordPress coding standards.

Use of Core APIs: The plugin correctly uses the Settings API, Transients API, and standard functions for enqueuing scripts and styles.

Gutenberg Development: The block is built with modern JavaScript (React) using the standard @wordpress/scripts package for a robust build process.

Setup and Installation
Prerequisites: You must have Node.js (v18+) and npm installed on your local machine or server to build the Gutenberg block assets.

Clone the Repository: Clone this repository into your wp-content/plugins/ directory.

Install PHP Dependencies: This plugin is self-contained and does not require a composer install.

Install JavaScript Dependencies: Navigate to the plugin's root directory in your terminal and run the following command to install the necessary packages for the Gutenberg block:

npm install

Build Block Assets: After the installation is complete, run the following command to compile the JavaScript and SCSS files for the block:

npm run build

Activate the Plugin: Log in to your WordPress admin dashboard, go to the "Plugins" page, and activate the "Advanced Odds Comparison" plugin.

How to Use
Configure Settings:

Navigate to Settings > Odds Comparison.

In the "Bookmakers" textarea, enter the names of the bookmakers you want to make available (one per line). For the demo scraper, use: Bet365, SkyBet, William Hill, Paddy Power.

Click Save Changes.

Use the Gutenberg Block:

Create a new post or edit an existing one.

Click the + icon to add a new block and search for "Odds Comparison Table".

Once the block is added, use the settings panel in the sidebar on the right to configure it:

Set a Market Title.

Check the boxes for the bookmakers you wish to display in this specific table.

Save your post. The live odds table will be rendered on the front end.
