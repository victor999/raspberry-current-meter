#!/usr/bin/env python
from ina219 import INA219
from ina219 import DeviceRangeError
import MySQLdb
from time import sleep
import time

SHUNT_OHMS = 0.1
MAX_EXPECTED_AMPS = 0.2


def read():

    db = MySQLdb.connect("localhost", "ina_user", "Your_password", "ina_data")

    cursor = db.cursor()

    ina = INA219(SHUNT_OHMS, MAX_EXPECTED_AMPS)
    ina.configure(ina.RANGE_16V, ina.GAIN_1_40MV)

    #print "Bus Voltage: %.3f V" % ina.voltage()
    #try:
        #print "Bus Current: %.3f mA" % ina.current()
        #print "Power: %.3f mW" % ina.power()
        #print "Shunt voltage: %.3f mV" % ina.shunt_voltage()
    #except DeviceRangeError as e:
        #print "Current overflow"

    millisec = int(round(time.time() * 1000))
    sql = "INSERT INTO ina_values(bus_voltage, load_voltage, current, millisec) VALUES('" + str(ina.voltage()) +"', '" + str(ina.shunt_voltage()) + "', '" + str(ina.current()) + "', '" + str(millisec) + "');"
    #print(sql)
    try:
        cursor.execute(sql)
        db.commit()
    except:
        db.rollback()

    db.close


if __name__ == "__main__":
    count = 1
    while(1):
        read()
        sleep(0.01)
        count += 1
        if(count > 10000):
            count = 0
            db = MySQLdb.connect("localhost", "ina_user", "Dbis4190", "ina_data")
            cursor = db.cursor()
            sql = "TRUNCATE ina_values;"
            try:
                cursor.execute(sql)
                db.commit()
            except:
                db.rollback()

            db.close
            
        


