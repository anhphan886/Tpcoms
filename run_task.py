import os
from time import sleep
import datetime


while True:
    os.system('php artisan command:taskschedule 1')
    sleep(10)
    x = datetime.datetime.now()
    print('[+] RUNNING TASK AT - ' + str(x))
