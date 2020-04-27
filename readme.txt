=== The Events Calendar Extension: Events Control ===
Contributors: ModernTribe
Donate link: http://m.tri.be/29
Tags: events, calendar
Requires at least: 4.5
Tested up to: 5.4
Requires PHP: 5.6
Stable tag: 1.4.0
License: GPL version 3 or any later version
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Adds the ability to mark an event as an Online event and to change an event's status to Canceled or Postponed.

== Description ==

Events marked as Online, Canceled, or Postponed will have a visual representation of those states in views and on the single event page. These event states also get reflected in the event schema with the `eventStatus` and `eventAttendanceMode` defined in Google's JSON-LD `Event` standard.

== Installation ==

Install and activate like any other plugin!

* You can upload the plugin zip file via the *Plugins ‣ Add New* screen
* You can unzip the plugin and then upload to your plugin directory (typically _wp-content/plugins_) via FTP
* Once it has been installed or uploaded, simply visit the main plugin list and activate it

== Frequently Asked Questions ==

= Where can I find more extensions? =

Please visit our [extension library](https://theeventscalendar.com/extensions/) to learn about our complete range of extensions for The Events Calendar and its associated plugins.

= What if I experience problems? =

We're always interested in your feedback and our [Help Desk](https://support.theeventscalendar.com/) are the best place to flag any issues. Do note, however, that the degree of support we provide for extensions like this one tends to be very limited.

== Changelog ==

= [1.4.0] TBD =

* Feature - Add online events indicator for The Events Calendar archive views. [EXT-166]
* Feature - Add canceled and postponed labels for The Events Calendar archive views. [EXT-165]
* Tweak - Text changes to the Event Status Metabox UI. [EXT-167]
* Tweak - Update status templates for canceled and postponed events on event single. [EXT-171]
* Fix - Modify the location schema to always include a url when using VirtualLocation and add a filter `tribe_events_single_event_online_status` to be able to set any event as an online event. [EXT-164]

= [1.3.0] 2020-04-18 =

* Fix - Make sure template injections from Event Control are looking for theme overwrites.

= [1.2.0] 2020-03-27 =

* Fix - Clean up status templates PHP to not overwrite notices.
* Fix - Prevent Status container from dislocating the title of events.
* Fix - Prevent Notices on `Event_Meta` methods that were accessing `$event->ID` without proper verification.

= [1.1.0] 2020-03-26 =

* Provide `event_status`, `event_status_reason`, `is_online`, and `online_url` in REST data for events.

= [1.0.0] 2020-03-24 =

* Initial release.
