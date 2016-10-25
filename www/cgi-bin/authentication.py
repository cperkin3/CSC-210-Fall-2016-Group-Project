from urllib2 import urlopen, HTTPError
import socket

url= ''

response = None

try:
    response = urlopen(url, timeout=150)
except HTTPError as exc:
    # A 401 unauthorized will raise an exception
    response = exc
except socket.timeout:
    print "Request timed out"

auth = response and response.info().getheader('WWW-Authenticate')
if auth and auth.lower().startswith('basic'):
    print "To view your profile, PLEASE Log In!".format(url)