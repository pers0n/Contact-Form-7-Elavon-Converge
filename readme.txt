=== Evalon Converge Payment CF7 Form ===


Tags: accept credit card payment, Additional Settings, CF7 elavon, contact form, contact form 7,Contact Form 7 + elavon, contact form 7 sagepay, contact form 7 to paypal redirect, contact forms, Contact Forms 7, contacted, contactform7, contacts, donation on WordPress site, form, forms, integrate elavon button, integrate elavon with contact form 7, integrate elavon with contact form 7, integrate elavon, online payment, pay online, payment using credit card, payments on WordPress site, elavon button, elavon donation, elavon Payment Gateway, elavon plugin for wordpress, Elavon submit, elavon, elavon API, elavon checkout, elavon donation, elavon integration in Contact Form 7, elavon payment, elavon payment gateway, elavon plugin for wordpress, super elavon, wp elavon

Requires at least: 3.0.1

Tested up to: 4.6

Stable tag: 1.1

License: GPLv3 or later License

CF7 requires at least: 3.0

CF7 tested up to: 4.5

Version: 1.1

License URI: http://www.gnu.org/licenses/gpl-3.0.html



Contact Form 7 - Integrate elavon payment gateway for making your payments through Contact Form 7. 



== Description ==



Considering the fact that Contact Form 7 is a highly common and authentic WordPress Plugin, the new addon "Evalon Converge Payment CF7 Form" can prove to be extremely helpful for users when it comes to receiving payments.



There is no denying the fact that, users of WordPress websites confront a lot of payment related issues on a day-to-day basis, and in that case Evalon Converge Payment CF7 Form can bring a great relief to them.



With the assistance of Evalon Converge Payment CF7 Form, you can receive credit card payments directly from your customers, thus preventing them from landing up on a third party payment page.



Evalon Converge Payment CF7 Form has the potential to receive payments safely from any Contact Form 7 form, which is hosted on any page or post for that matter. Once the contact form is submitted by the users, the payment checkout form is then displayed before them. The Elavon payment checkout form is used for quick and secure transactions. This simply indicates that Evalon Converge Payment CF7 Form can really help your websites to generate the revenue quickly.



What you need to understand about this plugin is it doesn't rely on the action handler 'on_set_ok', which resides on the 'Additional Settings' tab of the CF7. Instead of that users can find a new tab 'Elavon' wherein they can configure all the crucial fields needed to configure this plugin. For using this plugin, it is important for you to activate your Contact Form 7.




= Evalon Converge Payment CF7 Form Features =



*   It gives you the potential to create multiple payment forms using Contact Form 7.

*   In addition to that, it also supports multiple forms on a single post or page.

*   When it comes to receiving values from input fields such as drop-down menu, textbox, hidden field, radio buttons, etc., Evalon Converge Payment CF7 Form is really good at it.

*   The value for parameters like item company, amount, country, state, city and zip code is always accepted by it from the frontend.

*   When it comes to identifying whether the plugin is functioning properly or not, users can use Test API Mode.

*   The payment data associated to Contact Form 7 can be easily saved into the database.

*   Once a Elavon payment is made successfully by the customers, the plugin sends individual emails to both the customer and the admin.

*   You can personalize email content for this plugin, Email(1) of Contact Form 7 is send to payee after successful transaction and Email(2) is send to admin after successful or unsuccessful transaction.

*   [elavon] tag added to email content gets replaced by elavon payment response in email.

*   It allows you to set payment success return url and custom message.



== Plugin Requirement ==



PHP version : Compatible Up to 5.4

WordPress   : Wordpress 3.0 and latest



== Installation ==

1. Upload all files manually to your site's server and put inside your wp-content/plugins folder

2. Now login to your WordPress site and activate the plugin. Then, select 'edit' option in 'Contact Forms'.

3. You will find a new tab after "Additional Settings" tab. 

4. Fill in all the required fields to set up a Elavon payment gateway.



== Screenshots ==

1. Screenshot 'screenshot-1.png' shows all the possible options available for this plugin.

2. Screenshot 'screenshot-2.png' shows front end view for first screen of this plugin.

3. Screenshot 'screenshot-3.png' shows front end view for second screen of this plugin.



== Changelog ==

= 1.1 =

* Changed plugin name, so updates from the original GPLv3 Release by zealopensource won't conflict with this version. I needed something working ASAP.

* Fixed it so it will still send an email for the non-demo/test mode (the attachment paramter was preventing the email code from executing).

I reviewed the issue of email that is not receiving to recipient. I went through the cf7-elavon-converge-payment-form.php file where email sending is written. I made checks in all the conditions from where payment is passed. Then i found that the issue is with the senmaildetails function on line number 448, where code of email sending is written. Then i added my own static code for sending email and then made the payment. Then i received the email perfectly. After that i checked each parameter that passed throught the wp_mail function. Then i found that attachment parameter is preventing the email code to execute because attachment variable is not set. So i removed the attachment parameter and made the payment. After this change i received the email notification as expected. Also you will not receive any email if you are making test payments as the response sent from payment gateway is different for both Test and Live mode. And there is check for sending email only when response contains particular keywords and these keywords are only returned by payment gateway is set to Live.

= 1.01 =

* Fixed it so ssl_test_mode is set to false so real transactions can go through

* Removed a JavaScript reference to a file that doesnt exist on Evalon's website, the domain doesn't even resolve anymore either. It wasn't needed to work anyway.

= 1.0 =

* Initial GPLv3 Release by zealopensource at https://opensource.zealousweb.com/contact-form-7-elavon-converge/