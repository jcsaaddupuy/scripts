#!/usr/bin/env python
"""
	A sigle thread web server, may be usefull to share files.
"""
import BaseHTTPServer, SimpleHTTPServer
server = BaseHTTPServer.HTTPServer(('',8080),SimpleHTTPServer.SimpleHTTPRequestHandler)
server.serve_forever()
