from selenium import webdriver
from selenium.webdriver.common.by import By
import time

login = ['lvillachane','dandre','cbedos','ltusseau','pbentot',
'lbioret','fbunisset','dbunisset','bcacheux','ecadic','ccharoze',
'cclepkens','vcottin','fdaburon','pde','mdebelle','jdebelle',
'mdebroise','ndesmarquest','pdesnost','fdudouit','cduncombe',
'cenault','veynde','jfinck','ffremont','agest']
mdp = ['jux7g','oppg5','gmhxd','ktp3s','doyw1',
'hrjfs','4vbnd', 's1y1r','uf7r3','6u8dc',
'u817o','bw1us','2hoh9','7oqpv','gk9kx',
'od5rt','nvwqq','sghkb','f1fob','4k2o5',
'44im8','qf77j','y2qdu','i7sn3','mpb3t',
'xs5tq','dywvt']
code = '1234'
domainName= 'gsb-crochard'

driver = webdriver.Chrome()
driver.get("http://"+domainName+"/index.php?uc=connexion&action=valideConnexion")

i=0
while i<len(login)-1:
        driver.find_element(By.CSS_SELECTOR, 'input[name="login"]').clear()
        driver.find_element(By.CSS_SELECTOR, 'input[name="login"]').send_keys(login[i])
        driver.find_element(By.CSS_SELECTOR, 'input[name="mdp"]').clear()
        driver.find_element(By.CSS_SELECTOR, 'input[name="mdp"]').send_keys(mdp[i])
        driver.find_element(By.TAG_NAME, 'form').submit()
        driver.find_element(By.CSS_SELECTOR, 'input[name="code"]').send_keys(code)
        driver.find_element(By.TAG_NAME, 'form').submit()
        driver.get('http://'+domainName+'/index.php?uc=gererFrais&action=saisirFrais')
        time.sleep(1)
        driver.get('http://'+domainName+'/index.php?uc=deconnexion&action=demandeDeconnexion')
#         clickable = driver.find_element(By.TAG_NAME, 'Renseigner la fiche de frais')
#         ActionChains(driver)\
#             .context_click(clickable)\
#             .perform()
#         clickable2 = driver.find_element(By.TAG_NAME, 'Déconnexion')
#         ActionChains(driver)\
#             .context_click(clickable2)\
#             .perform()
        time.sleep(4)
        i+=1
driver.quit()
print("toutes les fiches de frais ont été mises à jour")