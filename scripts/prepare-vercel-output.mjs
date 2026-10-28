import { cp, mkdir, readdir, rm } from 'node:fs/promises';
import { join, resolve } from 'node:path';

const publicDirectory = resolve('public');
const outputDirectory = resolve('dist');
const excludedEntries = new Set([
    '.htaccess',
    'covid-19.sql',
    'index.php',
    'password.txt',
    'storage',
]);

await rm(outputDirectory, { recursive: true, force: true });
await mkdir(outputDirectory, { recursive: true });

for (const entry of await readdir(publicDirectory, { withFileTypes: true })) {
    if (excludedEntries.has(entry.name)) {
        continue;
    }

    await cp(
        join(publicDirectory, entry.name),
        join(outputDirectory, entry.name),
        { recursive: true },
    );
}
