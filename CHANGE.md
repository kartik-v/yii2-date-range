Change Log: `yii2-date-range`
=============================

## Version 1.7.4

- (enh #170) Update Russian Translations.
- (enh #173) Update Portuguese Translations.

## Version 1.7.3

**Date:** 01-Sep-2021

- (enh #163): Enhancements to support Bootstrap v5.x.
- (enh #162): Update Uzbek Translations.
- (enh #156): Update Greek Translations.
- (enh #155): Update Indonesian Translations.
- (enh #154): Update Kazakh Translations.
- (enh #150): Add following properties to DateRangePicker (applicable only when `presetDropdown` is `true`).
    - `includeDaysFilter` : _bool_ defaults to `true`
    - `presetFilterDays` : _array_ defaults to `[7, 30]`
    - If above is true - following preset options are additionally available:
        - **Last 7 Days**
        - **Last 30 Days**
    - `includeMonthsFilter` : _bool_ defaults to `false`
    - `presetFilterMonths` : _array_ defaults to `[3, 6, 12]`
    - If above is true - following preset options are additionally available:
       - **Last 6 Months**
       - **Last 12 Months**

## Version 1.7.2

**Date:** 09-Feb-2020

- (enh #148): Correct date range preset dropdown selection for "Today".
- (enh #147): Allow date range picker value to be cleared for preset dropdown.
- (enh #146): Enhance preset dropdown user interface.
- (enh #143): Update initSettings to support indexes.

## Version 1.7.1

**Date:** 17-May-2019

- (enh #139): Update Latvian Translations.
- (enh #134): Merge ranges for preset dropdown.
- Implement stale bot.

## Version 1.7.0

**Date:** 09-Oct-2018

- Update composer dependencies.
- (enh #129): Update Russian Translations.
- (enh #128): Move init moment() variable.
- Enhancements to support Bootstrap 4.x.
- (enh #126): Fix `kv-drp-container` CSS style.
- (enh #125): Add Czech Translations.
- (enh #122): Better responsive styling of preset dropdown.
- (bug #119): Correct client validation of model range attributes.
- (enh #118): More correct predefined default date ranges.
- Update to latest release v3.0.3 of `daterangepicker` plugin.
- Reorganize code in `src` folder.
- (enh #113): Allow specifying direction in preset dropdown.

## Version 1.6.9

**Date:** 15-Mar-2018

- (enh #112): New boolean property `encodeValue` to HTML encode the value (to prevent XSS).
- (enh #81, #108): Enhance empty date validation.
- (bug #104, bug #111): Allow specifying direction in preset dropdown.

## Version 1.6.8

**Date:** 08-Aug-2017

- Chronological arrangement of issues in CHANGE.log.
- (enh #101): Update Turkish Translations.
- (enh #98): Update Danish Translations.
- (enh #97): Update Hebrew Translations.
- (enh #95): Update Chinese Traditional Translations.
- (enh #93): Various styling enhancements and preset plugin defaults for preset dropdown.
- (enh #92): Correct example for Date Range Behavior in README.md.
- Add github contribution and issue/PR logging templates.
- Update daterangepicker library to latest release.
- (enh #91): Update moment library to latest release.
- (enh #90): Add Date Range Behavior for easier application with model range attributes.
- (enh #88): Enhance preset dropdown to default today's date when date is empty.
- (enh #85, #86): Add Greek Translations.

## Version 1.6.7

**Date:** 12-Jul-2016

- (bug #76, #77, #78, #79): Correct dependency for `DateRangePickerAsset`.
- (bug #75): Correct code for PHP 5.5.
- (bug #74): Correct asset bundle dependency.
- (bug #73): Correct dependency for `DateRangePickerAsset` and `LanguageAsset`.
- (enh #71): Add Thai translations.
- (bug #70): More better attribute and input options parsing.
- (enh #68): Update to latest release of bootstrap-daterangepicker plugin and moment library.
- (enh #67): Parse input change correctly when range input value is cleared.
- (bug #65): Correct moment `weekdaysStart` to `weekdaysMin`.
- Add branch alias for dev-master latest release.
- (enh #62): Add Romanian Translations.
- (enh #61): Add Dutch Translations.
- (enh #59): Add Hungarian Translations.
- (enh #58): Add support for separate start and end attributes and inputs.

## Version 1.6.6

**Date:** 11-Jan-2016

- (enh #56): Update to latest version of bootstrap-daterangepicker.
- (enh #55): Enhancements for PJAX based reinitialization. Complements enhancements in kartik-v/yii2-krajee-base#52 and kartik-v/yii2-krajee-base#53.

## Version 1.6.5

**Date:** 22-Oct-2015

- (enh #53): Added correct German translations.
- (enh #52): New property `autoUpdateOnInit` to prevent plugin triggering change due to `pluginOptions['autoUpdateInput']` default setting.

## Version 1.6.4

**Date:** 19-Oct-2015

- (enh #51): Update to latest release of bootstrap-datarangepicker plugin.
- (enh #43): Add Slovak translations.
- (enh #41): Add Simplified Chinese translations.

## Version 1.6.3

**Date:** 22-May-2015

- (enh #40): Update moment library and locales.
- (enh #38): Update to latest release of bootstrap-datarangepicker plugin.
- (enh #36): Add Polish translations.
- (enh #32): Add Portugese translations.
- (enh #31): Add Ukranian translations.

## Version 1.6.2

**Date:** 02-Mar-2015

- (enh #29): Improve validation to retrieve the right translation messages folder.
- (enh #28): Upgrade to latest release of bootstrap-daterangepicker plugin.
- (enh #27): Correct initial value initialization for all cases.
- Set copyright year to current.

## Version 1.6.1

**Date:** 16-Feb-2015

- Set copyright year to current.
- (enh #28): Upgrade to latest release of bootstrap-daterangepicker plugin.
- (enh #27): Correct initial value initialization for all cases.

## Version 1.6.0

**Date:** 12-Jan-2015

- Revamp to use new Krajee base InputWidget and TranslationTrait.
- Code formatting updates as per Yii2 standards.
- (enh #23): Russian translations updated.
- (enh #22): Estonian translation for kvdrp.php

## Version 1.5.0

**Date:** 29-Nov-2014

- (enh #20): Enhance language locale file parsing and registering
    - Remove `_localeLang` property
    - Rename `locale` folder to `locales` to be consistent with `datepicker` and `datetimepicker` plugins
    - Utilize enhancements in krajee base [enh #9](https://github.com/kartik-v/yii2-krajee-base/issues/9) and  [enh #10 ](https://github.com/kartik-v/yii2-krajee-base/issues/10) 
    - Update `LanguageAsset` for new path

## Version 1.4.0

**Date:** 25-Nov-2014

- (enh #19): Enhance widget to use updated plugin registration from Krajee base 
- (bug #18): Plugin data attributes not set because of input rendering sequence.
- (enh #17): Updated Russian translations

## Version 1.3.0

**Date:** 21-Nov-2014

- (enh #16): Update Lithunian translations and create German translations.
- (enh #15): Revamp widget to remove dependency on custom locale JS files enhancement
- (enh #14): Update moment library to latest release.
- (enh #13): Update moment.js related range initializations.
- (enh #12): Added Spanish Translations
- (enh #7): Added Russian Translations

## Version 1.2.0

**Date:** 20-Nov-2014

- Upgrade to latest plugin release 1.3.16 dated 12-Nov-2014.
- (bug #11): Fix bug in daterangepicker.js for duplicate dates in Dec 2013.

## Version 1.1.0

**Date:** 10-Nov-2014

- Set release to stable
- Set dependency on Krajee base components
- PSR4 alias change

## Version 1.0.0

**Date:** 09-May-2014

- Initial release