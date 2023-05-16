import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery',
        },
    },
    build: {
      rollupOptions: {
        output: {
          manualChunks: {
            'vendor-bootstrap': ['bootstrap'],
            'vendor-admin-lte': ['admin-lte'],
            'vendor-datatable': [
              'admin-lte/plugins/datatables/jquery.dataTables.min.js',
              'admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
              'admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js',
              'admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min',
            ],
          },
        },
      },
    }
});
