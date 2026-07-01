import js from "@eslint/js";
import globals from "globals";
import { defineConfig } from "eslint/config";
import stylistic from '@stylistic/eslint-plugin'

export default defineConfig([
	{
		files: ["**/*.{js,mjs,cjs}"],
		plugins: {
			'@stylistic': stylistic,
			js,
		},
		extends: ["js/recommended"],
		languageOptions: { globals: globals.browser },
		rules: {
			'@stylistic/indent': ['error', 'tab'],
		}
	},
]);
