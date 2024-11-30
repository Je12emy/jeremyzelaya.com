---
title: A working Neovim setup for Laravel
publication_date: "2024-11-01"
tags:
    - nvim
    - laravel
slug: nvim-for-laravel
summary: "Recently, I gained interest in learning Laravel. Howevever, there are few things to keep in mind if you plan on using neovim for your next Laravel app."
---

When I decided to learn Laravel, I assumed configuring Neovim would be as straightforward as setting it up for any other language. However, I quickly discovered a few extra steps were necessary to achieve a smooth development experience with Laravel.

# Two PHP LSPs? Which One to Choose?

The Neovim LSP Config documentation lists two available LSP servers for PHP: PHP Actor and Intelephense.
-   [Intelephense](https://intelephense.com/) is a "freemium" LSP. While it provides basic functionality for free, features like variable renaming and code actions require a $25 USD lifetime license.
-   [PHP Actor](https://github.com/phpactor/phpactor) is a free alternative that includes the core features you'd expect from an LSP.

In my experience, Intelephense produced fewer diagnostic errors, likely due to Laravel's "magic". That said, PHP Actor is a solid option, and I recommend trying both to see which works best for you. Maybe try PHP Actor while you are learning Laravel to see if you would like to invest on Intelephense.

## Laravel IDE Helper

Laravel can confuse LSPs, which is where [Laravel IDE Helper package](https://github.com/barryvdh/laravel-ide-helper) comes in. It is a CLI that generates helper files that improve auto-completion and solves diagnostic errors.

First, install it as a development dependency in your project.

```shell
composer require --dev barryvdh/laravel-ide-helper
```

And generate helper files (you are supposed to add these to your `.gitignore`).

```shell
php artisan ide-helper:generate
```

There are many more features offered by this CLI (please check the documentation), if you enjoy using wrappers around these sort of CLI's within neovim you could checkout [Laravel IDE Helper NVIM](https://github.com/Bleksak/laravel-ide-helper.nvim).

# Blade Syntax Highlighting with Tree-Sitter

You can install `php_only` if you are only interested on using Laravel as your API [backend](https://github.com/tree-sitter/tree-sitter-php/issues/257#issuecomment-2336738026). If you would are interested on front-end development with `blade` components, you should install the php and [tree-sitter-blade](https://github.com/EmranMR/tree-sitter-blade) grammars.

To set tree-sitter-blade up, copy the following [code snippet](https://github.com/EmranMR/tree-sitter-blade/discussions/19#discussioncomment-8541804) into your neovim configuration.

```lua
local treesiter = require("nvim-treesitter.configs")
local parser_config = require "nvim-treesitter.parsers".get_parser_configs()
parser_config.blade = {
    install_info = {
        url = "https://github.com/EmranMR/tree-sitter-blade",
        files = { "src/parser.c" },
        branch = "main",
    },
    filetype = "blade"
}

vim.filetype.add({
    pattern = {
        ['.*%.blade%.php'] = 'blade',
    }
})
local bladeGrp
vim.api.nvim_create_augroup("BladeFiltypeRelated", { clear = true })
vim.api.nvim_create_autocmd({ "BufNewFile", "BufRead" }, {
    pattern = "*.blade.php",
    group = bladeGrp,
    callback = function()
        vim.opt.filetype = "blade"
    end,
})
```

Create the following file structure in your neovim configuration directory.

```
after
└── queries
    └── blade
        ├── highlights.scm
        └── injections.scm

3 directories, 2 files
```

Paste the following content in `highlights.scm`.

```
# File: highlights.scm
(directive) @function
(directive_start) @function
(directive_end) @function
(comment) @comment
((parameter) @include (#set! "priority" 110))
((php_only) @include (#set! "priority" 110))
((bracket_start) @function (#set! "priority" 120))
((bracket_end) @function (#set! "priority" 120))
(keyword) @function
```

Paste the following content in `injections.scm`.

```
# File: injections.scm
((text) @injection.content
    (#not-has-ancestor? @injection.content "envoy")
    (#set! injection.combined)
    (#set! injection.language php))
```

_Note_: Here is a [git commit](https://github.com/Je12emy/dotfiles/commit/e9a678d640f47b15f0117fefae25cc3dfdfbc717) if you would like to verify my changes.

After this is done, you should be able install the blade grammar with `TSInstall blade`. I do recommend you also install the `html`, `css` and `javascript` grammars for the next step.

# Adding HTML LSP Support for Blade Templates

This should provide a good enough experience, in my case I also want to write CSS and Javascript inside my blade components. This can be done with the HTML LSP, we simply enable it on `blade` files.

To do so, you simply add the `blade` file type to the configuration.

```lua
-- $ npm install -g vscode-langservers-extracted
local capabilities = vim.lsp.protocol.make_client_capabilities()
capabilities.textDocument.completion.completionItem.snippetSupport = true
lspconfig.html.setup {
    capabilities = capabilities,
    filetypes = { "html", "blade" },
    init_options = {
        configurationSection = { "html", "css", "javascript" },
        embeddedLanguages = {
            css = true,
            javascript = true
        },
        provideFormatter = true
    }
}
```

# Code Formatting

I use Conform.nvim for formatting code. Here, I picked [Pint](https://github.com/laravel/pint) since it was developed by the Laravel team.

```lua
require("conform").setup({
    formatters_by_ft = {
        -- Laravel's Formatter
        -- See: https://github.com/laravel/pint
        php = { "pint" },
    }
})
```

For blade files it is possible to use prettier, but if you are already set-up with HTML LSP, then it will provide formatting out of the box.

# More Plugins

I also decided to ask around on Reddit to see if I was missing an essential plugin. You may take a look at the thread filled with recommendations here.

-   [Recommended plugins for Laravel?](https://www.reddit.com/r/neovim/comments/1gjn991/recommended_plugins_for_laravel/)

It also looks like an official VS Code plugin is being developed by the Laravel team, I have seen rummors about an LSP being considered. So there is hope that the development experience may improve for Neovim users.

-   [Tweet by Laravel News](https://x.com/laravelnews/status/1828539011486622085)
