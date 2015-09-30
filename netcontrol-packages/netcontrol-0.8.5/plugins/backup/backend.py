#-*- coding: utf-8 -*-
"""
Copyright (C) 2012 FluxSoftwares <http://www.fluxsoftwares.com>.
(Escrito por Jacson Rodrigues Correia da Silva <jacsonrcsilva@gmail.com> e João Paulo Constantino <joaopauloctga@gmail.com> para FluxSoftwares)

Este arquivo é parte do programa NetControl.

O NetControl é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão 2 da Licença.

Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.

Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt", junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301, USA
"""
from netcontrol.api import *
from netcontrol.utils import *
from netcontrol.com import *
import os
 
class Host:
    def __init__(self):
        self.name = '';
 
 
class Config(Plugin):
    implements(IConfigurable)
    name = 'Backup'
    icon = '/dl/backup/icon.png'
    id = 'backup'
 
    def list_files(self):
        return ['/etc/backup']
 
    def read(self):
        DIR = '/var/backups/netcontrol/'
        if not os.access( DIR, 7 ):
            try: os.mkdir (DIR, 0700)
            except: return []

        ss = os.listdir( DIR )
        return ss
 
    def save(self, hosts):
        d = ''
        for h in hosts:
            d += '%s\n' % (h.name)
        ConfManager.get().save('backup', '/var/lib/netcontrol/plugins/backup/lista_bcks', d)
        ConfManager.get().commit('backup')
