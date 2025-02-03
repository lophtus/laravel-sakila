import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import commonjs from 'vite-plugin-commonjs';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
              'resources/js/admin/styles/app.scss',
              'resources/js/admin/app.ts',
              'resources/js/styles/app.scss',
              'resources/js/app.ts'
            ],
            refresh: true,
        }),
        vue(),
        commonjs(),
    ],
    resolve: {
      extensions: [ '.js', '.ts', '.vue' ],
      alias: {
        '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        '~@coreui': path.resolve(__dirname, 'node_modules/@coreui'),
        '~@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome'),
      }
    },
    server: {
      host: true,
      cors: true,
      hmr: {
        host: "localhost"
      }
    }
});
