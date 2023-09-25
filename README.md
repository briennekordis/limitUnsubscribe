# Limit Unsubscribe
A CiviCRM extension that acts as a safegaurd to prevent users from ubsubscribing an entire mailing list serve, if the group consists of a minimum number of contacts (i.e. a Google Group).

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v7.4+
* (developed on) CiviCRM 5.66.alpha1

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl limitunsubscribe@https://github.com/FIXME/limitunsubscribe/archive/master.zip
```
or
```bash
cd <extension-dir>
cv dl limitunsubscribe@https://lab.civicrm.org/extensions/limitunsubscribe/-/archive/main/limitunsubscribe-main.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/limitunsubscribe.git
cv en limitunsubscribe
```
or
```bash
git clone https://lab.civicrm.org/extensions/limitunsubscribe.git
cv en limitunsubscribe
```

## Getting Started

Currently, the `$contactMin` variable is set to `3`, based on specs received from the client requesting this extension. You may want to adjust this minimum depending on the users' needs of your CiviCRM instance.

