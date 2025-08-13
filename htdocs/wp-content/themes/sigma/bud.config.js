/**
 * @typedef {import('@roots/bud').Bud} Bud
 *
 * @param {Bud} app
 */
export default async (app) => {
  app
    /**
     * Application entrypoints
     *
     * @see https://bud.js.org/docs/bud.entry
     */
    .entry({
      app: ['@scripts/app', '@styles/app'],
      editor: ['@scripts/editor', '@styles/editor'],
    })

    /**
     * Directory contents to be included in the distribution
     *
     * @see https://bud.js.org/docs/bud.copy
     */
    .copy(['resources/images'])

    /**
     * Watched files, directories, and extensions
     *
     * @see https://bud.js.org/docs/bud.watch
     */
    .watch(['resources/views', 'app'])

    /**
     * URI of the `public` directory
     *
     * @see https://bud.js.org/docs/bud.setPublicPath
     */
    .setPublicPath('/app/themes/sigma/public/')

    /**
     * Development server settings
     *
     * @see https://bud.js.org/docs/bud.proxy
     */
    .proxy('http://wp4458.nexgenwebz.com')

    /**
     * Development server URL
     *
     * @see https://bud.js.org/docs/bud.serve
     */
    .serve('http://0.0.0.0:3000');
};
