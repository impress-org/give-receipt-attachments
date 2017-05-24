=== Give Receipt Attachments ===
Contributors: webdevmattcrom
Donate link: https://www.mattcromwell.com/products/give-receipt-attachments
Tags: givewp, donation, donations, attachment, receipt
Requires at least: 4.0
Tested up to: 4.5.2
Stable tag: 1.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.en.html

A Give Add-on which allows you to upload a file to use as an attachment on your donation email receipts and donation confirmation page.

== Description ==

A [Give](https://givewp.com) Addon which allows you to add a file to any Give donation form and have it appear for your donors to download via the donation confirmation page and email confirmation.

This has many potential use-cases. Here's a few ideas:

* Provide a PDF Gift Certificate to those who donate over a certain amount
* Give a MP3 song as thanks to your donors
* Give a ZIP file (like a free WordPress plugin) to your donors

**FEATURES**

* Choose custom title text for the confirmation page
* Choose custom link text for the download
* Upload your file via the Media Library Uploader
* Optionally set a minimum donation amount per form for the Gift to be available to the donor.
* Add the link to your Admin notification email and/or the Donor notification email via a custom Email tag.
* Forms that don't have uploads are not affected in any way.

**BASIC USAGE**

At the bottom of each Give Form edit screen you'll find the Give Receipt Attachments settings area. You configure that per form. This includes the minimum donation amount necessary for the attachment to be available (optionally).

If you upload a file and configure the settings there, the attachment title and link will appear automatically before the Donation Receipt table on your Donation Confirmation page.

In order to have the attachment link appear in your donation receipt emails, go to "Donations > Settings" then the Emails tab. In the Donation Receipt email field add {attachmenturl} anywhere you like. Below that field you'll see a full list of all the available email tags.

**ABOUT MATT CROMWELL**
> I'm Head of Support and Community Outreach at [WordImpress](https://wordimpress.com). Our most popular plugin is [Give](https://wordpress.org/plugins/give), the leading donation plugin for WordPress. I build custom WordPress plugins and themes and blog frequently at [mattcromwell.com](https://www.mattcromwell.com) on WordPress, Religion and Politics, and Family life. 
> 
> If you are enjoying Give Receipt Attachments please consider [giving a donation](https://www.mattcromwell.com/products/give-receipt-attachments) to support my free plugin and theme development. All donations provided through my website go to [help San Diego nonprofit organizations with their hosting and web maintenance](https://www.mattcromwell.com/help-me-help-others/). 

== Installation ==

= Minimum Requirements =

* WordPress 4.0 or greater
* PHP version 5.3 or greater
* MySQL version 5.0.15 or greater

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To install Give Receipt Attachments, login to your WordPress dashboard, navigate to the Plugins menu and click "Add New".

In the search field type "Give Receipt Attachments" and click Search Plugins. Once you have found the plugin you can view details about it such as the the point release, ratings and description. Most importantly of course, you can install it by simply clicking "Install Now".

= Manual installation =

The manual installation method involves downloading the plugin and uploading it to your server via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site before doing any plugin or theme updates just in case. If you have any trouble with an update, try out our [WP-Rollback plugin](https://wordpress.org/plugins/wp-rollback) which lets you revert to previous versions of WordPress plugins or themes with just a couple clicks.


== Frequently Asked Questions ==

= What file types are supported? =

Give Receipt Attachments uses the Media Library to upload your attachments. This means that you can use any file type that the Media Library supports. [See a full list here](https://codex.wordpress.org/Uploading_Files).

= Where can I submit Support Questions? =

I'll answer all inquiries [here](https://wordpress.org/support/plugin/give-receipt-attachments).

= I have a feature request, or would like to contribute to this plugin. Where can I do that? =

Give Receipt Attachments is hosted publicly on Github. I'd love your feedback and suggestions [there](https://github.com/mathetos/give-receipt-attachments/issues).

= I really love this Add-on. Can I donate a bit to you for making it? =

I really appreciate that! You can donate here.

Please know that all donations generated through my website go to support my family and local nonprofits in San Diego. [Read more about that here](https://www.mattcromwell.com/help-me-help-others/).

== Screenshots ==

1. The Attachment Title and Link displayed on the Give Donation Confirmation page.
2. The Attachment link displayed inside the Give Donation Receipt Email.
3. Adding the Attachment link to your donation receipt email requires adding the {attachmenturl} email tag.
4. The settings for Give Receipt Attachments that are displayed at the bottom of each Give form edit screen.

== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
This is the initial release. Thanks for installing!