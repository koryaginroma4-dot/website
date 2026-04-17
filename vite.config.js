import { defineConfig } from 'vite';
import symfonyPlugin from 'vite-plugin-symfony';
import path from 'path';

export default defineConfig({
    plugins: [symfonyPlugin()],
    resolve: {
        alias: {
            '@images': path.resolve(__dirname, 'src-front/images')
        }
    },
    build: {
        manifest: true,
        publicDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                main: path.resolve(__dirname, 'src-front/main.ts')
            }
        }
    },
});
