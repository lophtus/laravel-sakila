module.exports = {
  // ... other configurations
  parser: "vue-eslint-parser",
  parserOptions: {
    parser: "@typescript-eslint/parser",
    sourceType: "module",
  },
  plugins: ["@typescript-eslint"],
  extends: [
    // ... other extends
    "plugin:@typescript-eslint/recommended",
  ],
  rules: {
    // ... your rules
  },
};
