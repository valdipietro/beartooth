-- -----------------------------------------------------
-- Operations
-- -----------------------------------------------------
SET AUTOCOMMIT=0;

-- address
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "address", "delete", true, "Removes a participant's address entry from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "address", "edit", true, "Edits the details of a participant's address entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "address", "new", true, "Creates a new address entry for a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "address", "add", true, "View a form for creating new address entry for a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "address", "view", true, "View the details of a participant's particular address entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "address", "list", true, "Lists a participant's address entries." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "address", "primary", true, "Retrieves base address information." );

-- appointment
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "appointment", "delete", true, "Removes a participant's appointment from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "appointment", "edit", true, "Edits the details of a participant's appointment." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "appointment", "new", true, "Creates new appointment entry for a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "appointment", "add", true, "View a form for creating new appointments for a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "appointment", "view", true, "View the details of a participant's particular appointment." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "appointment", "list", true, "Lists a participant's appointments." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "appointment", "primary", true, "Retrieves base appointment information." );

-- assignment
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "assignment", "view", true, "View assignment details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "assignment", "list", true, "Lists assignments." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "home_assignment", "select", true, "Provides a list of participants ready for a home appointment to begin an assignment with." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "site_assignment", "select", true, "Provides a list of participants ready for a site appointment to begin an assignment with." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "assignment", "begin", true, "Begins a new assignment with a particular participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "assignment", "end", true, "Ends the current assignment." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "assignment", "primary", true, "Retrieves base assignment information." );

-- availability
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "availability", "delete", true, "Removes a participant's availability entry from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "availability", "edit", true, "Edits the details of a participant's availability entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "availability", "new", true, "Creates new availability entry for a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "availability", "add", true, "View a form for creating new availability entry for a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "availability", "view", true, "View the details of a participant's particular availability entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "availability", "list", true, "Lists a participant's availability entries." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "availability", "primary", true, "Retrieves base availability information." );

-- calendar
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "widget", "shift_template", "calendar", true, "Shows shift templates in a calendar format." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "pull", "shift_template", "feed", true, "Retrieves a list of shift templates for a given time-span." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "home_appointment", "calendar", true, "A calendar listing home appointments." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "home_appointment", "feed", true, "Retrieves a list of home appointment times for a given time-span." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "site_appointment", "calendar", true, "A calendar listing site appointments." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "site_appointment", "feed", true, "Retrieves a list of site appointment times for a given time-span." );

-- consent
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "consent", "delete", true, "Removes a participant's consent entry from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "consent", "edit", true, "Edits the details of a participant's consent entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "consent", "new", true, "Creates new consent entry for a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "consent", "add", true, "View a form for creating new consent entry for a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "consent", "view", true, "View the details of a participant's particular consent entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "consent", "list", true, "Lists a participant's consent entries." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "consent", "primary", true, "Retrieves base consent information." );

-- interview
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "interview", "view", true, "View interview details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "interview", "list", true, "Lists interviews." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "interview", "edit", true, "Edits the details of an interview." );

-- onyx operations
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "appointment", "list", true, "Retrieves a list of appointments for an onyx instance." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "onyx", "participants", true, "Allows Onyx to update the information of one or more participants." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "onyx", "consent", true, "Allows Onyx to update the consent details of one or more participants." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "onyx", "proxy", true, "Allows Onyx to update the proxy details of one or more participants." );

-- onyx_instance
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "onyx_instance", "delete", true, "Removes a onyx instance from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "onyx_instance", "edit", true, "Edits a onyx instance's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "onyx_instance", "new", true, "Add a new onyx instance to the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "onyx_instance", "add", true, "View a form for creating a new onyx instance." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "onyx_instance", "view", true, "View a onyx instance's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "onyx_instance", "list", true, "List onyx instances in the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "onyx_instance", "primary", true, "Retrieves base onyx instance information." );

-- participant
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "participant", "delete", true, "Removes a participant from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "participant", "edit", true, "Edits a participant's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "participant", "new", true, "Add a new participant to the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant", "add", true, "View a form for creating a new participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant", "view", true, "View a participant's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant", "list", true, "List participants in the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant", "add_appointment", true, "A form to create a new appointment to add to a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "participant", "delete_appointment", true, "Remove a participant's appointment." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant", "add_availability", true, "A form to create a new availability entry to add to a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "participant", "delete_availability", true, "Remove a participant's availability entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant", "add_consent", true, "A form to create a new consent entry to add to a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "participant", "delete_consent", true, "Remove a participant's consent entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant", "add_address", true, "A form to create a new address entry to add to a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "participant", "delete_address", true, "Remove a participant's address entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant", "add_phone", true, "A form to create a new phone entry to add to a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "participant", "delete_phone", true, "Remove a participant's phone entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant", "tree", true, "Displays participants in a tree format, revealing which queue the belong to." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "participant", "tree", true, "Returns the number of participants for every node of the participant tree." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "participant", "primary", true, "Retrieves base participant information." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "participant", "list", true, "Retrieves base information for a list of participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "participant", "withdraw", true, "Withdraws the participant (or cancels the withdraw).  This is meant to be used during an interview if the participant suddenly wishes to withdraw." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant", "sync", true, "A form to synchronise participants between Beartooth and Mastodon." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "participant", "sync", true, "Returns a summary of changes to be made given a list of UIDs to sync." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "participant", "sync", true, "Updates participants with their information in Mastodon." );

-- phase
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "phase", "delete", true, "Removes a phase from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "phase", "edit", true, "Edits a phase's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "phase", "new", true, "Creates a new questionnaire phase." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "phase", "add", true, "View a form for creating a new phase." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "phase", "view", true, "View the details of a questionnaire's phases." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "phase", "list", true, "Lists a questionnaire's phases." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "phase", "primary", true, "Retrieves base phase information." );

-- phone
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "phone", "delete", true, "Removes a participant's phone entry from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "phone", "edit", true, "Edits the details of a participant's phone entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "phone", "new", true, "Creates a new phone entry for a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "phone", "add", true, "View a form for creating new phone entry for a participant." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "phone", "view", true, "View the details of a participant's particular phone entry." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "phone", "list", true, "Lists a participant's phone entries." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "phone", "primary", true, "Retrieves base phone information." );

-- phone call
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "phone_call", "list", true, "Lists phone calls." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "phone_call", "begin", true, "Starts a new phone call." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "phone_call", "end", true, "Ends the current phone call." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "phone_call", "primary", true, "Retrieves base phone call information." );

-- qnaire
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "qnaire", "delete", true, "Removes a questionnaire from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "qnaire", "edit", true, "Edits a questionnaire's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "qnaire", "new", true, "Add a new questionnaire to the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "qnaire", "add", true, "View a form for creating a new questionnaire." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "qnaire", "view", true, "View a questionnaire's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "qnaire", "list", true, "List questionnaires in the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "qnaire", "add_phase", true, "View surveys to add as a new phase to a questionnaire." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "qnaire", "delete_phase", true, "Remove phases from a questionnaire." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "qnaire", "primary", true, "Retrieves base qnaire information." );

-- queue
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "queue", "list", true, "List queues in the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "queue", "view", true, "View a queue's details and list of participants." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "queue", "primary", true, "Retrieves base queue information." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "queue_restriction", "delete", true, "Removes a queue restriction from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "queue_restriction", "edit", true, "Edits a queue restriction's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "queue_restriction", "new", true, "Add a new queue restriction to the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "queue_restriction", "add", true, "View a form for creating a new queue restriction." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "queue_restriction", "view", true, "View a queue restriction's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "queue_restriction", "list", true, "List queue restrictions in the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "queue_restriction", "primary", true, "Retrieves base queue restriction information." );

-- quota
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "quota", "delete", true, "Removes a quota from the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "quota", "edit", true, "Edits a quota's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "quota", "new", true, "Add a new quota to the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "quota", "add", true, "View a form for creating a new quota." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "quota", "view", true, "View a quota's details." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "quota", "list", true, "List quotas in the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "quota", "primary", true, "Retrieves base quota information." );

-- reports
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "widget", "productivity", "report", true, "Set up a productivity report." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "pull", "productivity", "report", true, "Download a productivity report." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "widget", "call_attempts", "report", true, "Set up a call attempts report." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "pull", "call_attempts", "report", true, "Download a call attempts report." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "widget", "call_history", "report", true, "Set up a call history report." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "pull", "call_history", "report", true, "Download a call history report." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "widget", "sourcing_required", "report", true, "Set up a new sourcing required report." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "pull", "sourcing_required", "report", true, "Download a new sourcing required report." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "widget", "demographics", "report", true, "Set up a new demographics report." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "pull", "demographics", "report", true, "Download a new demographics report." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "progress", "report", true, "Set up a progress report." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "progress", "report", true, "Download a progress report." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "participant_tree", "report", true, "Set up a participant tree report." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "participant_tree", "report", true, "Download a participant tree report." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "home_appointment", "report", true, "Set up a home appointment report." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "home_appointment", "report", true, "Download a home appointment report." );

-- self
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "self", "dialing_pad", false, "A telephone dialing pad widget." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "self", "assignment", false, "Displays the assignment manager." );

-- shift_template
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "push", "shift_template", "delete", true, "Removes a shift template from the system." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "push", "shift_template", "edit", true, "Edits a shift template's details." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "push", "shift_template", "new", true, "Add a new shift template to the system." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "widget", "shift_template", "add", true, "View a form for creating a new shift template." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "widget", "shift_template", "view", true, "View a shift template's details." );
-- INSERT INTO operation( type, subject, name, restricted, description )
-- VALUES( "pull", "shift_template", "primary", true, "Retrieves base shift template information." );

-- survey
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "widget", "survey", "list", true, "List surveys in the system." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "pull", "survey", "primary", true, "Retrieves base survey information." );

-- voip
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "voip", "dtmf", true, "Sends a DTMF tone to the Asterisk server." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "voip", "play", true, "Plays a sound over the Asterisk server." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "voip", "begin_monitor", true, "Starts monitoring the active call." );
INSERT INTO operation( type, subject, name, restricted, description )
VALUES( "push", "voip", "end_monitor", true, "Stops monitoring the active call." );

COMMIT;
