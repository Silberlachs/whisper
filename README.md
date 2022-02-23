# whisper
wordpress bridge to MS Teams / Discord

To install just use composer as you would for any other PHP project.
Requires PHP 8, but SHOULD be downwards compatible to 7.4, maybe you'd need to mod a call here and there.

Currently known issues:

When ANOTHER plugin also tries to listen for publish_post hook, like "share on mastodon" or some 
WooCommerce Stuff, it can happen that our hook is triggered multiple times. I will look into this, 
until then you can either activate each plugin seperately to post to the respective platforms,
or you'll have to live with your post beeing duplicated. 
From my experiance it is much less of a pain to have 2 discord posts with the same post rather than
having f.e. 2 Twitter posts in your timeline that are duplicates - this is only a minor issue but 
it IS an issue. 
Maybe checking for explicit REST calls is an option here, as stated in 
https://wordpress.stackexchange.com/questions/221202/does-something-like-is-rest-exist

This is not a critical bug, rather a nasty codestain.
