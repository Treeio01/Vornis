// vite.config.js
import { defineConfig } from "file:///Users/danilcernov/Desktop/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B/vornis/node_modules/vite/dist/node/index.js";
import laravel from "file:///Users/danilcernov/Desktop/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B/vornis/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///Users/danilcernov/Desktop/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B/vornis/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import tailwindcss from "file:///Users/danilcernov/Desktop/%D0%9F%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D1%8B/vornis/node_modules/@tailwindcss/vite/dist/index.mjs";
import path from "path";
var __vite_injected_original_dirname = "/Users/danilcernov/Desktop/\u041F\u0440\u043E\u0435\u043A\u0442\u044B/vornis";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: "resources/js/app.js",
      refresh: true
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    }),
    tailwindcss()
  ],
  resolve: {
    alias: {
      "@": path.resolve(__vite_injected_original_dirname, "resources/js"),
      "~": path.resolve(__vite_injected_original_dirname, "resources")
    }
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCIvVXNlcnMvZGFuaWxjZXJub3YvRGVza3RvcC9cdTA0MUZcdTA0NDBcdTA0M0VcdTA0MzVcdTA0M0FcdTA0NDJcdTA0NEIvdm9ybmlzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCIvVXNlcnMvZGFuaWxjZXJub3YvRGVza3RvcC9cdTA0MUZcdTA0NDBcdTA0M0VcdTA0MzVcdTA0M0FcdTA0NDJcdTA0NEIvdm9ybmlzL3ZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9Vc2Vycy9kYW5pbGNlcm5vdi9EZXNrdG9wLyVEMCU5RiVEMSU4MCVEMCVCRSVEMCVCNSVEMCVCQSVEMSU4MiVEMSU4Qi92b3JuaXMvdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcbmltcG9ydCBsYXJhdmVsIGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xuaW1wb3J0IHZ1ZSBmcm9tICdAdml0ZWpzL3BsdWdpbi12dWUnO1xuaW1wb3J0IHRhaWx3aW5kY3NzIGZyb20gXCJAdGFpbHdpbmRjc3Mvdml0ZVwiO1xuaW1wb3J0IHBhdGggZnJvbSAncGF0aCdcbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiAncmVzb3VyY2VzL2pzL2FwcC5qcycsXG5cbiAgICAgICAgICAgIHJlZnJlc2g6IHRydWUsXG4gICAgICAgIH0pLFxuICAgICAgICB2dWUoe1xuICAgICAgICAgICAgdGVtcGxhdGU6IHtcbiAgICAgICAgICAgICAgICB0cmFuc2Zvcm1Bc3NldFVybHM6IHtcbiAgICAgICAgICAgICAgICAgICAgYmFzZTogbnVsbCxcbiAgICAgICAgICAgICAgICAgICAgaW5jbHVkZUFic29sdXRlOiBmYWxzZSxcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgfSxcbiAgICAgICAgfSksXG4gICAgICAgIHRhaWx3aW5kY3NzKClcbiAgICBdLFxuICAgIHJlc29sdmU6IHtcbiAgICAgICAgYWxpYXM6IHtcbiAgICAgICAgICAgICdAJzogcGF0aC5yZXNvbHZlKF9fZGlybmFtZSwgJ3Jlc291cmNlcy9qcycpLFxuICAgICAgICAgICAgJ34nOiBwYXRoLnJlc29sdmUoX19kaXJuYW1lLCAncmVzb3VyY2VzJyksXG4gICAgICAgIH0sXG4gICAgfSxcbn0pO1xuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUFnVixTQUFTLG9CQUFvQjtBQUM3VyxPQUFPLGFBQWE7QUFDcEIsT0FBTyxTQUFTO0FBQ2hCLE9BQU8saUJBQWlCO0FBQ3hCLE9BQU8sVUFBVTtBQUpqQixJQUFNLG1DQUFtQztBQUt6QyxJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPO0FBQUEsTUFFUCxTQUFTO0FBQUEsSUFDYixDQUFDO0FBQUEsSUFDRCxJQUFJO0FBQUEsTUFDQSxVQUFVO0FBQUEsUUFDTixvQkFBb0I7QUFBQSxVQUNoQixNQUFNO0FBQUEsVUFDTixpQkFBaUI7QUFBQSxRQUNyQjtBQUFBLE1BQ0o7QUFBQSxJQUNKLENBQUM7QUFBQSxJQUNELFlBQVk7QUFBQSxFQUNoQjtBQUFBLEVBQ0EsU0FBUztBQUFBLElBQ0wsT0FBTztBQUFBLE1BQ0gsS0FBSyxLQUFLLFFBQVEsa0NBQVcsY0FBYztBQUFBLE1BQzNDLEtBQUssS0FBSyxRQUFRLGtDQUFXLFdBQVc7QUFBQSxJQUM1QztBQUFBLEVBQ0o7QUFDSixDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
