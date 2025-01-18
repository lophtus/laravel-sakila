import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue2 from '@vitejs/plugin-vue2';
import commonjs from 'vite-plugin-commonjs';

const path = require('path')

export default defineConfig({
    plugins: [
        laravel({
            input: [
              'resources/sass/admin/app.scss',
              'resources/js/admin/app.ts',
              'resources/sass/app.scss',
              'resources/js/app.ts'
            ],
            refresh: true,
        }),
        vue2(/* options */),
        commonjs(),
    ],
    resolve: {
      extensions: [ '.js', '.ts', '.vue' ],
      alias: {
        '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        '~bootstrap-vue': path.resolve(__dirname, 'node_modules/bootstrap-vue'),
        '~@coreui': path.resolve(__dirname, 'node_modules/@coreui'),
        '~@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome'),
      }
    },
    server: {
      watch: {
        usePolling: true,
      }
    }
});
