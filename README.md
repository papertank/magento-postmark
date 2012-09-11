# Custom Postmark Magento Integration 

Postmark (postmarkapp.com) is an email delivery service which relieves the hassle of using the local server for outgoing mail. Using a PHP library and an API, this module overwrites the Magento e-mail model so that outgoing mail is passed through Postmark.

## Installation

Upload the contents of the `app` folder to your Magento root, but as always be careful not to overwrite the existing files / folders. If you cannot using a tool like `rsync`, it may be better to copy the files manually into the relevant subdirectories, creating the folders if necessary.

You can rename `Papertank` to your own company / project name to keep this and other Magento local modules organised. As well as renaming the `app/code/local/Papertank` folder and `app/etc/modules/Papertank_Postmark.xml` filename, you should find and replace `Papertank` with your value in all files (except `Postmark.php`).

## API Key / Email

Once you have uploaded the files, you *must* add in your own Postmark API key and your outgoing email signature address in the `Postmark.php` file. Update the following lines with information from your Postmark control panel.

	$this->api_key = 'your-api-key-here';
	$this->data['From'] = 'Your Name <you@example.com>';
  	
## Troubleshooting

As with all Magento modules, you can confirm if Magento has identified it by looking in the admin area under `System > Configuration > Advanced > Disable Modules Output`. If your module (ie. Papertank_Postmark) does not appear in the list, Magento isn't recognising it for some reason.

If you decided to rename the module from `Papertank_Postmark` to your own company / project name, check that you used the same new name in the folders and updated all references in the files.

## Development

- Source hosted at [GitHub](https://github.com/papertank/magento-postmark)

## Changelog


## Authors

[Papertank](https://github.com/papertank)

## Credits

[A Simple Postmark PHP Class (Gist)](https://gist.github.com/1314065) created by [Matthew Loberg](https://github.com/mloberg) & extended by [Drew Johnston](https://github.com/drewjoh).

## Notes

Postmark is trademark of Wildbit, LLC