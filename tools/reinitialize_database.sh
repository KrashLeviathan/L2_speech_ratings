#!/usr/bin/env bash

# Run from the root directory

mysql -u root -p < "sql/drop_tables.sql"
mysql -u root -p < "sql/create_tables.sql"
mysql -u root -p < "sql/config_initial_values.sql"
