from selenium import webdriver

driver=webdriver.Chrome("/Applications/chromedriver")

driver.get("http://localhost/SE-1/")

#driver.find_element_by_id("user_name").send_keys("1234")
#driver.find_element_by_id("password").send_keys("abcde")

#driver.find_element("id","user_name").send_keys("1234")
#driver.find_element("id","password").send_keys("abcde")

driver.find_element(By.NAME, "UserID")
driver.find_element(By.NAME, "Password")


# driver.find_element_by_id
