-- Doctrine Migration File Generated on 2023-05-28 10:19:52

-- Version DoctrineMigrations\Version20230528093750
ALTER TABLE profile_scope DROP FOREIGN KEY FK_F77BCA01B6C79646;
DROP INDEX IDX_F77BCA01B6C79646 ON profile_scope;
ALTER TABLE profile_scope DROP scopes_id;
-- Version DoctrineMigrations\Version20230528093750 update table metadata;
DELETE FROM doctrine_migration_versions WHERE version = 'DoctrineMigrations\\Version20230528093750';
