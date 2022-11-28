from webbrowser import Chrome
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
import unittest

serv_obj=Service("/Applications/chromedriver")
driver=webdriver.Chrome(service=serv_obj)
driver.maximize_window()
actual_url="http://localhost/SE-1/passenger/dashboard.php"

# driver=webdriver.Chrome("/Applications/chromedriver")

def test_case():

    driver.get("http://localhost/SE-1/")
    driver.find_element(By.NAME, "UserID").send_keys("1234")
    driver.find_element(By.NAME, "Password").send_keys("abcde")
    driver.find_element(By.NAME, "signin").click()
    get_url = driver.current_url
    return str(get_url)

# if actual_url==get_url:
#     print("Test Case Passed")

class TestMain(unittest.TestCase):
    def test_add(self):
        self.assertEqual(test_case(),actual_url)