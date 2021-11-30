-- Drop everything in the database
source drop_triggers.sql;
source drop_procedures.sql;
source drop_views.sql;
source drop_tables.sql;

-- Add everything back in
source create_tables.sql;
source create_views.sql;
source create_procedures.sql;
source create_triggers.sql;
source create_data.sql;