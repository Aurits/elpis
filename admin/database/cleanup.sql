-- ===================================================================
-- CLEANUP SCRIPT - Elpis Initiative Uganda Database
-- ===================================================================
-- This script will clean up the database and prepare it for fresh import
-- Use this if you had a failed import or want to start over
-- ===================================================================
-- Use the database
USE u508604795_elpis;
-- ===================================================================
-- STEP 1: Drop all triggers first (to avoid dependency issues)
-- ===================================================================
DROP TRIGGER IF EXISTS after_application_status_update;
DROP TRIGGER IF EXISTS after_donation_insert;
DROP TRIGGER IF EXISTS after_subscription_insert;
-- ===================================================================
-- STEP 2: Drop all views
-- ===================================================================
DROP VIEW IF EXISTS vw_dashboard_stats;
DROP VIEW IF EXISTS vw_recent_activity;
DROP VIEW IF EXISTS vw_monthly_donations;
DROP VIEW IF EXISTS vw_applications_by_department;
-- ===================================================================
-- STEP 3: Drop all functions
-- ===================================================================
DROP FUNCTION IF EXISTS get_next_application_id;
DROP FUNCTION IF EXISTS get_next_donation_id;
DROP FUNCTION IF EXISTS get_next_subscription_id;
DROP FUNCTION IF EXISTS get_next_partner_id;
-- ===================================================================
-- STEP 4: Drop all tables (in correct order to avoid foreign key issues)
-- ===================================================================
DROP TABLE IF EXISTS email_queue;
DROP TABLE IF EXISTS file_uploads;
DROP TABLE IF EXISTS newsletter_campaigns;
DROP TABLE IF EXISTS activity_logs;
DROP TABLE IF EXISTS subscriptions;
DROP TABLE IF EXISTS donations;
DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS admin_users;
-- ===================================================================
-- CLEANUP COMPLETE
-- ===================================================================
-- Now you can re-import the main SQL file:
-- mysql -u u508604795_elpis -p u508604795_elpis < elpis_db.sql
-- ===================================================================