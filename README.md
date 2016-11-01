# Feedify
PHP RSS News Feed

View the working site at http://peppertech.co.uk/feedify/

# How Feedify Works
A cron job is run every 30 mins (at the moment) which runs the php autoChanSubmit.php in the _rootfiles. This loops through the RSS feeds that are submitted to the site.


The posts and feeds and categories are stored in a database that will be accessed when a user hits the site.

# How to use the website
You can create your own channel or genre by inputting an RSS url in the url box, and then inputting the channel name you want in "channel". If it doesn't already exist, it will be created.


All feeds are shown in "all".


You can view the feeds in that channel by hitting "Feed list".


The "Share" button will share the link to Facebook if required.

# Other features that aren't visible to user yet
- Posts are marked with "New" if the user has not seen that post yet. Does not work across pages.

- You can show just a single post by inputting id= into the parameters querystring. Potential to have comments or discussion
