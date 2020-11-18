## 1.4
Added
  - added brandCode to json_extra for Intake model
  - added `label_low` & `label_high` for rating component
  - added `json_extra` to `form` table
  - added `json_extra`, `process_by` and `date_processed` to `form_submission` table
  - ordering for forms at side nav is display accordingly to `form2intake.ordering`
  - fixed bug in `HubForm::convertJsonToHtml` to not display form saved message when view in readonly mode
  - fixed checkbox component bugs created @mahboubian
  - added feature to improve textbox and list component to support `$preset[FIELD_NAME]`
  - fixed missing submission id in notice url after save submission
  - added deactivated/activate separate view for intake and form admin
  

## 1.2
Added
  - added `json_event_mapping` to form table to allow storing of sync instruction
  - added form to backend dashboard, display currently opening form
  - added feature to include f7 form in advance search
  
Changed
  - changed search on title in f7' admin page now auto search intake too
  - fixed bug in `HubForm::convertJsonToHtml` where admin view submission not showing startup name correctly


## 1.1