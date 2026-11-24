<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards the Claude blog connector. The secret is part of the connector URL
 * (/mcp/blog/{token}), because Claude custom connectors cannot send a fixed
 * Authorization header. Without CLAUDE_MCP_TOKEN set, the endpoint is off.
 */
class VerifyClaudeMcpToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $expected = (string) config('services.claude_mcp.token');
        $given = (string) $request->route('token');

        if (strlen($expected) < 32 || ! hash_equals($expected, $given)) {
            abort(404);
        }

        // Keep the secret out of anything downstream that reads route parameters.
        $request->route()->forgetParameter('token');

        return $next($request);
    }
}
