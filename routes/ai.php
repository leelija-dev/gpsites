<?php

use App\Http\Middleware\VerifyClaudeMcpToken;
use App\Mcp\Servers\BlogServer;
use Laravel\Mcp\Facades\Mcp;

// Claude connector for writing and scheduling blog posts.
// Connector URL: https://gpsites.io/mcp/blog/<CLAUDE_MCP_TOKEN>
Mcp::web('/mcp/blog/{token}', BlogServer::class)
    ->middleware([VerifyClaudeMcpToken::class, 'throttle:60,1'])
    ->name('mcp.blog');
