<?php

namespace App\Core;

use Illuminate\Database\Capsule\Manager as DataBase;

class Migration
{
    /**
     * Run the migration files in the specified directory.
     *
     * @param string $migrationsPath The path to the migrate folder.
     * @return void
     */
    public static function migrate(string $migrationsPath = BASEPATH . 'database/migrations'): void
    {
        $startTime = microtime(true);
        try {
            # Fetch list of executed migrations
            $executedMigrations = DataBase::table('migrations')->pluck('migration')->toArray();
            $migrationFiles = glob($migrationsPath . '/*.php');

            # Loop through each migration file
            foreach ($migrationFiles as $file) {
                $migrationName = basename($file, '.php');

                # Skip migration if it has already been executed
                if (in_array($migrationName, $executedMigrations)) {
                    continue;
                }

                # Include migration file
                require_once $file;

                # Generate the migration class name
                $migrationClass = self::generateClassName($migrationName);

                # Check if the class exists before instantiation
                if (!class_exists($migrationClass)) {
                    echo "\e[31m✘ \e[0m Class $migrationClass not found. Check your migration file naming.\n";
                    continue;
                }

                # Run the migration
                (new $migrationClass())->up();

                # Insert record into migrations table
                $executionTime = round((microtime(true) - $startTime) * 1000, 2);
                DataBase::table('migrations')->insert(['migration' => $migrationName]);
                echo "\e[32m✔ \e[0m Migrated : " . substr($migrationName, 10) . " {$executionTime} ms\n";
            }
        } catch (\Exception $e) {
            echo "\e[31m✘ \e[0m Migration Failed: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Rollback the last executed migration.
     *
     * @param string $migrationsPath The path to the migrate folder.
     * @return void
     */
    public static function rollback(string $migrationsPath = BASEPATH . 'database/migrations'): void
    {
        $startTime = microtime(true);
        try {
            # Fetch executed migrations in reverse order
            $executedMigrations = DataBase::table('migrations')->orderBy('id', 'desc')->get();

            if ($executedMigrations->isEmpty()) {
                echo "No Migrations To Roll Back.\n";
                return;
            }

            foreach ($executedMigrations as $migration) {
                $migrationName = $migration->migration;
                $fileName = $migrationsPath . '/' . strtolower(self::formatFileName($migrationName)) . '.php';

                # Check if the migration file exists
                if (!file_exists($fileName)) {
                    echo "\e[31m✘ \e[0m Migration File $fileName Not Found. Skipping Rollback.\n";
                    continue;
                }

                # Include migration file
                require_once $fileName;

                # Generate the migration class name
                $migrationClass = self::generateClassName($migrationName);

                # Run the rollback
                if (class_exists($migrationClass)) {
                    (new $migrationClass())->down();
                    $executionTime = round((microtime(true) - $startTime) * 1000, 2);
                    DataBase::table('migrations')->where('migration', $migrationName)->delete();
                    echo "\e[32m✔ \e[0m Rolled back: " . substr($migrationName, 10) . " {$executionTime} ms\n";
                } else {
                    echo "\e[31m✘ \e[0m Class $migrationClass Not Found in $fileName.\n";
                }
            }
        } catch (\Exception $e) {
            echo "\e[31m✘ \e[0m Rollback Failed: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Generate migration class name from file name.
     *
     * @param string $migrationName The original migration file name.
     * @return string The formatted class name.
     */
    private static function generateClassName(string $migrationName): string
    {
        # Example: 01_create_table_users -> CreateTableUsers
        $nameParts = array_slice(explode('_', $migrationName), 1);
        return implode('', array_map('ucfirst', $nameParts));
    }

    /**
     * Format the migration file name for rollback.
     *
     * @param string $migrationName The migration class name.
     * @return string The formatted file name.
     */
    private static function formatFileName(string $migrationName): string
    {
        $splitName = preg_split('/(?=[A-Z])/', $migrationName);
        return strtolower(implode('_', $splitName));
    }
}
