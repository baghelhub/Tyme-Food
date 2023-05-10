=== WordPress Ens Age Verification ===
Contributors: ens team
Tags:ens age verification, age popup, age restriction, age verifier. 
Requires at least: 4.5.0
Tested up to: 7.0
Requires PHP: 7.0
Stable tag: 6.6.1
License: later
License URI: 'lic url'

Ens Age Verification is designed to be SEO-friendly, and requires users to confirm their age, or acceptance of terms on your website or woocommerce store. All of the text and colors are customizable! 
This plugin is absolutely, 100% free and open-source.

**How to Use**
Simply install the plugin, and it's ready to go! You can customize the text in Settings-> Ens Age Verification Settings


**Need help?**
You can get help or leave feature requests on the support page or send us an email: plugins
[Report a Bugs](site ur for bugs )


**Features**
- Ens Age verification that works on desktop, and supports nearly all devices.
- Designed to have as minimal of an SEO impact as possible.
- It's customizable; you can require verficiation or acceptance of nearly anything.
- Easy for developers to modify. You can make most customizations only using CSS.

[Ens Age Verification Plugin for WordPress, Designsmoke](site url for help us)


**Customizations**
-- Background Image (CSS) --
```div#age-verification {
    background-image: url('/wp-content/uploads/your-image.jpg');
    background-size: cover;
    background-position: center center;
}```

-- Rounded Box (CSS) --
```.age-verification-main {
    border-radius:10px;
}```

-- Box Border (CSS) --
```.age-verification-main {
    border: 3px solid #ffffff;
}```


-- Company Logo (CSS) --
```.age-verification-main span.age-title::before {
    content: ' ';
    display: block;
    width: 150px;
    height: 65px;
    background-image: url('/wp-content/uploads/your-logo.jpg');
    background-size: contain;
    background-position: center center;
    background-repeat: no-repeat;
    margin: 0 auto 5px auto;
}```

**Updates**
-- 6.0 (March 16, 2022) --
Fixed popup on mobile getting cut off on certain Apple devices (iPhone)

-- 1.3.0 (May 16, 2019) --
Allows you to set the duration before the user needs to verify their age again.

-- 1.2.0 (May 9, 2019) --
Enhanced text visibility on popup for lighter colors (text-shadow). Added preview button. Updated rating and plugin text on admin page.

-- 1.1.0 --
Fixed color picker not showing on latest WordPress version. Added information on adding custom images and theming support. Added rating notification.

-- 1.0.6 --
Fixed settings sometimes not saving. Fixed age verification taking too long to show up.

--- File    Structure 
      Root folders and files
      --  admin  [js,css,img,setting update file]
      --  ageDb  [table creation structure file,drop table file (during activation and 
               deactivation) ]
      --  setting form
      --  verify popup form
      -- main file same as plugin name



== Screenshots ==

1. Wordpress Age Verification Plugin Screenshot
2. Ens Age Verification Plugin popup


