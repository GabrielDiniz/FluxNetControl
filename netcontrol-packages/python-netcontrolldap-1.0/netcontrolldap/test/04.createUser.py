from netcontrolldap import netcontrolldap
from pprint import pprint
from ConfigParser import ConfigParser

cfg = ConfigParser()
cfg.read('/etc/ldap/netcontrol')
server  = cfg.get('base', 'server')
bindDN  = cfg.get('base', 'bindDN')                       
adminPW = cfg.get('base', 'adminPW')
del cfg

o = netcontrolldap.LDAPConnection(server, ssl=True, admPasswd=adminPW, baseDN=bindDN)

print o.addUser('jeiks', 'Jacson', '123456', createHome=True)
print o.findUser('jeiks')

o.closeConnection()
