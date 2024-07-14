# Team F11 Milestone 3 code for final product
# Created by: Mathilde Stolz, Gaurav S Patangay, Pui Wing Ng, Kashish Sood, Athena Riziq
# Created date: 9/04/2024
# Version = '1.0'

import matplotlib.pyplot as plt
from pymata4 import pymata4
import time
import math
 

board = pymata4.Pymata4()

# # led pins
# mainRoadRed = 9
# mainRoadYellow = 8
# mainRoadGreen = 7
# sideRoadRed = 4
# sideRoadYellow = 3
# sideRoadGreen = 2
# pedestrianRed = 5
# pedestrianGreen = 6

# Thermistor pin
thermistorPin = 0 # Analog Pin

# Constants for thermistor
Vin = 5.0  # Input voltage
R1 = 10000.0  # Fixed resistor value in ohms

# default pin
global savedPin, num_attempts
savedPin = "1234"
num_attempts = 3


# default max height 
global maxHeight 
maxHeight = 10

# default ssd message
global ssdMessage
ssdMessage = "NO CURRENT STAGE "

# default polling rate
global pollingRate
pollingRate = 3

# lists for cycle time and distance values
global distanceValues
global timeValues
distanceValues = []
timeValues = []

ser = 4
rclk = 3
srclk = 2

board.set_pin_mode_digital_output(ser)    
board.set_pin_mode_digital_output(rclk)    
board.set_pin_mode_digital_output(srclk)   

leds = '00000000'

def stage_two_five_buzzer(pwmInput):
    board.set_pin_mode_pwm_output(pwmInput)
    startTime2 = time.time()
    while True:
        try:
            board.pwm_write(pwmInput, 100)
            time.sleep(0.1)

            elapsedTime2 = time.time() - startTime2
            if elapsedTime2 > 3:
                break
        except KeyboardInterrupt:
            display_main_menu()
    board.pwm_write(pwmInput,0)


def display_main_menu():
    """
        Used to display the main menu of the system, where the user can select which mode they would like to enter
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    print("\nMain Menu")
    print("-------------------------")
    print("1: Normal Mode")
    print("2: Data Observation Mode")
    print("3: Maintenance Adjustment Mode")
    while True:  # Wait for input
        try:
            choice = int(input("Option: "))
            if choice == 1:
                normal_operation_mode()
                break  # Break the loop if the function call is successful
            elif choice == 2:
                # if timeValues and distanceValues:  # Check if the lists are initialized and have data
                data_observation_mode(timeValues, distanceValues)
                break  # Break the loop if the function call is successful
                # else:
                #     print("Data not available. Initialize data first.")
                #     continue  # Stay in the loop to get a valid input
            elif choice == 3:
                maintenance_adjustment_mode()
                break  # Break the loop if the function call is successful
            else:
                print("Please enter a valid option (1, 2, or 3).")
        except ValueError:
            print("Error: Only numbers are accepted.")
        except KeyboardInterrupt:
            board.send_reset()
            quit()


def control_subsystem():
    """
        Used to call on the input and output subsystems 
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """

    output_subsystem()


# def mam_flashing():
#     while True:
#         try:
#             board.set_pin_mode_digital_output(sideRoadYellow)
#             board.digital_pin_write(sideRoadYellow, 1)

#             board.set_pin_mode_digital_output(mainRoadYellow)
#             board.digital_pin_write(mainRoadYellow, 1)
#             time.sleep(0.5)
#             board.set_pin_mode_digital_output(sideRoadYellow)
#             board.digital_pin_write(sideRoadYellow, 0)

#             board.set_pin_mode_digital_output(mainRoadYellow)
#             board.digital_pin_write(mainRoadYellow, 0)
#             time.sleep(0.5)
#         except KeyboardInterrupt:
#             board.digital_pin_write(sideRoadYellow, 0)
#             board.digital_pin_write(mainRoadYellow, 0)
#             display_main_menu()


def access_timeout():
    start_Time = time.time()
    duraction = 300
    status_timeout = False
    while True:
        current_Time = time.time()
        elapsed_time = current_Time - start_Time
        if elapsed_time >= duraction:
            print("System timed out")
            status_timeout = True
            break
    if status_timeout == True:
        display_main_menu()

def pin_check2():
    """
            Asks user for pin to enter maintenance adjustment mode and denies access if incorrect pin is given
                Parameters:
                    Function has no parameters
                Returns:
                    Function has no return
        """
    global savedPin, num_attempts


    try:
        while True:

            entered_pin = input("Enter your PIN: ")
            if entered_pin == savedPin:
                print("PIN correct. Access granted.")
                break

            else:
                num_attempts = num_attempts - 1

            if num_attempts == 0:
                print("PIN incorrect. Access blocked for 2 minutes. Access will be given in 2 minutes.")
                time.sleep(120)
                num_attempts = 3

            else:
                print(f"PIN incorrect. {num_attempts} attempts left.")


    except KeyboardInterrupt:
        print("\nReturning to Main Menu...\n")
        display_main_menu()


def current_stage():
    """
        Used to output the current stage of the polling cycle 
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    global consoleOutput
    consoleOutput = ""
    if (currentStage == 1):
        seven_segment_display(ssdMessage = " Stage One ")
        consoleOutput = "Stage One"
    elif (currentStage == 2):
        seven_segment_display(ssdMessage = " Stage Two ")
        consoleOutput = "Stage Two"
    elif (currentStage == 3):
        seven_segment_display(ssdMessage = " Stage Three ")
        consoleOutput = "Stage Three"
    elif (currentStage == 4):
        seven_segment_display(ssdMessage = " Stage Four ")
        consoleOutput = "Stage Four"
    elif (currentStage == 5):
        seven_segment_display(ssdMessage = " Stage Five ")
        consoleOutput = "Stage Five"
    elif (currentStage == 6):
        seven_segment_display(ssdMessage = " Stage Six ")
        consoleOutput = "Stage Six"
    else:
        seven_segment_display(ssdMessage = "No current Stage")

    print(f"\nCurrent Stage: {consoleOutput}")
    return None

tempData = []

def process_thermistor_data(data):
    """
    A callback function to report data changes.
    :param data: [pin_mode, pin, current_reported_value,  timestamp]
    """
    tempData.append(data) # data is the Raw data from Thermistor



# Steinhart-Hart coefficients for a typical TCS610 10 kΩ THERMISTOR 
A = 1.1279*10**(-3)
B = 2.3429*10**(-4)
C = 8.7298*10**(-8)

def calculate_temperature():
    global tempData
    tempData = []  # Clear the tempData list at the beginning of the polling period
    samples = []
    start_time = time.time()
    while time.time() - start_time < pollingRate:
        if tempData:
            latest_data = tempData[-1]
            Vout = (latest_data[2] / 1023.0) * Vin
            R2 = R1 * (Vin / Vout - 1.0)
            lnR2 = math.log(R2)
            inv_T = A + B * lnR2 + C * (lnR2 ** 3)
            temperature_K = 1.0 / inv_T  # Temperature in Kelvin
            temperature_C = temperature_K - 273.15  # Convert to Celsius
            seven_segment_display(ssdMessage = str(int(float(temperature))))
            if 0 <= temperature_C <= 50:
                samples.append(temperature_C)
            time.sleep(0.51)  
    if samples:
        temperature = sum(samples) / len(samples)  # Average temperature
        return temperature
    else:
        return None


def initialize_thermistor():
    board.set_pin_mode_analog_input(thermistorPin, process_thermistor_data)
    
def the_callback(data):
    """
        Updates the global LatestDistance with the new sensor reading 
            Parameters:
                data: data from the ultrasonic sensor including the distance measurements 
            Returns:
                Function has no return
    """
    global latestDistance, distance_readings
    distance_readings =[]

    # Add the new reading to the list
    distance_readings.append(data[2])

    # Keep only the last 5 readings
    if len(distance_readings) > 5:
        distance_readings.pop(0)

    # Calculate the moving average
    latestDistance = sum(distance_readings) / len(distance_readings)
def height_sensor(data):
    """
        Updates the global LatestDistance with the new sensor reading 
            Parameters:
                data: data from the ultrasonic sensor including the distance measurements 
            Returns:
                Function has no return
    """
    global latestHeight
    latestHeight = data[2]  # Data[2] contains the distance measurement


def leds_on(leds):
    for i in leds:
        board.digital_pin_write(ser,int(i))
        board.digital_pin_write(srclk,1)
        board.digital_pin_write(srclk,0)
    board.digital_pin_write(rclk,1)
    board.digital_pin_write(rclk,0)


   

def turnOff():
    off = '00000000'
    for i in off:
        board.digital_pin_write(ser,int(i))
        board.digital_pin_write(srclk,1)
        board.digital_pin_write(srclk,0)
        board.digital_pin_write(rclk,1)
        board.digital_pin_write(rclk,0)

def pushbutton(data):
    """
        Collects data from pedestrian push button and keeps track of pedestrian presence and how many pedestrians are present 
            Parameters:
                data: data from the push button, whether it has been pressed or not
            Returns:
                Function has no return
    """
    global pedestrainCount, tempPedestrainPresence, peButtoncount
    global pedestrainPresence, numPresses
    global buttonValue
    global buttonPin

    peButtoncount = 1
    pedestrainCount = []
    tempPedestrainPresence = False
    buttonPin = 7
    pedestrainPresence = False
    numPresses = 0

    buttonValue = data[2]
    #print(data[2])

    if buttonValue == 1:
        print("Pushbutton is pressed")

        # tempPedestrainPresence = True
        # pedestrainPresence = tempPedestrainPresence
        # pedestrainCount.append(peButtoncount)
        # peButtoncount = peButtoncount + 1
        # numPresses = len(pedestrainCount)

    board.set_pin_mode_digital_input(buttonPin, callback=pushbutton)

    # try:
    #     while True:
    #         time.sleep(0.1)
    # except KeyboardInterrupt:
    #     #numPresses = len(pedestrainCount)
    #     #print(f"Pedestrian Presence: {pedestrainPresence}\n")
    #     #print(f"Pedestrian Count: {numPresses}")
    #     display_main_menu()


def stage_one_led():
    """
        Setting leds as input or output depending on the stage
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    leds = '00101100'
    leds_on(leds)


def stage_two_led():
    """
        Setting leds as input or output depending on the stage
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """

    leds = '01001100'
    leds_on(leds)


def stage_three_led():
    """
        Setting leds as input or output depending on the stage
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
   
    leds = '10001100'
    leds_on(leds)


def stage_four_led():
    """
        Setting leds as input or output depending on the stage
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
 
    leds = '10010001'
    leds_on(leds)

def stage_five_led():
    """
        Setting leds as input or output depending on the stage
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
 
    leds = '10010010'
    leds_on(leds) 


def stage_six_led():
    """
        Setting leds as input or output depending on the stage
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    leds = '10001100'
    leds_on(leds)

def stage_one():
    """
        Runs when the stage begins. Displays current stage, distance, and total cycle time at the polling rate
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    global currentStage
    global mainRoadLED
    global sideRoadLED
    global pedestrianRoadLED

    stage1_duration = 0
    currentStage = 1
    mainRoadLED = "GREEN"
    sideRoadLED = "RED"
    pedestrianRoadLED = "RED"
    

    try:
        current_stage()
        stage_one_led()
        print(
            f"Main road: {mainRoadLED}\nSide road: {sideRoadLED}\nPedestrian road: {pedestrianRoadLED}\nthe following lights will be display for 30 seconds\n"
        )
        global startTime, pedestrainPresence, pedestrainCount, peButtoncount, numPresses
        startTime = time.time()
        startTime2 = time.time()
        global totalTime
        global totalTime1
        global timeValues
        global distanceValues
        global buttonPin

        distanceValues = []
        timeValues = []
        global numPresses
        tempTotalTime = None
        board.set_pin_mode_analog_input(LDRpin)

        while True:
            endTime = time.time()
            totalTime1 = endTime - startTime
            totalTime = totalTime1
            rateTime = endTime - startTime2
            board.sonar_read(triggerPin)
            board.sonar_read(triggerPin2)
            LDRvalue = board.analog_read(LDRpin)[0]
            temperature = calculate_temperature() 
            global buttonValue

            if buttonValue is not None:
                stage1_duration = totalTime1 + 5
                tempPedestrainPresence = True
                pedestrainPresence = tempPedestrainPresence
                pedestrainCount.append(peButtoncount)
                peButtoncount = peButtoncount + 1
                numPresses += 1
                buttonValue = None
                board.set_pin_mode_digital_input(buttonPin,
callback=pushbutton)

            #if pedestrainPresence == True:
            #   stage1_Time = 5
            #  if tempTotalTime == None:
            #       tempTotalTime = time.time()
            #   elif totalTime1 - tempTotalTime >= stage1_Time:
            #       print(f"\nPolling cycle time elapsed: {totalTime:.2f}\n", end='\r' f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")
            #       clear()
            #       break
            if LDRvalue < 20:
                stage1_duration = 45
            elif LDRvalue > 20:
                stage1_duration = 30
            
            try:
                if latestHeight >= maxHeight:
                    print(f"Vehicle is {latestHeight}cm, so it is too high!")
                    board.set_pin_mode_digital_output(8)
                    board.digital_pin_write(8,1)
                    time.sleep(2)
                    board.digital_pin_write(8,0)
            except TypeError or ValueError:
                pass
            if totalTime1 >= stage1_duration:
                print(f"\nPolling cycle time elapsed: {totalTime:.2f}\n", end='\r' f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")
                    
                break
            elif rateTime >= pollingRate:
                board.sonar_read(triggerPin)
                board.sonar_read(triggerPin2)

            if latestDistance is not None:
                print(f"\nPolling cycle time elapsed: {totalTime:.2f}\nCurrent stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")

                distanceValues.append(latestDistance)
                timeValues.append(totalTime)
                try:
                    speed = (distanceValues[-1] -
                                distanceValues[-2]) / pollingRate
                    if float(speed) > 3:
                        print(
                            "VEHICLE IS GOING TOO FAST. PLEASE SLOW DOWN.")
                    if float(speed) == 0:
                        print("Car is not moving")
                    else:
                        pass
                except IndexError:
                    pass
                startTime2 = time.time()
                continue
            else:
                continue
    except KeyboardInterrupt:
        turnOff()
        display_main_menu()


def stage_two():
    """
        Runs when the stage begins. Displays current stage, distance, and total cycle time at the polling rate
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    pwmPinStage2 = 9 
    stage_two_five_buzzer(pwmPinStage2)

    global currentStage
    currentStage = 2
    mainRoadLED = "YELLOW"
    sideRoadLED = "RED"
    pedestrianRoadLED = "RED"


    try:
        current_stage()
        stage_two_led()
        print(
            f"Main road: {mainRoadLED}\nSide road: {sideRoadLED}\nPedestrian road: {pedestrianRoadLED}\nthe following lights will be display for 30 seconds\n"
        )
        global startTime, pedestrainPresence, pedestrainCount, peButtoncount, numPresses
        startTime2 = time.time()
        global totalTime
        global distanceValues
        global totalTime2
        startTime3 = time.time()
        board.set_pin_mode_analog_input(LDRpin)

        while True:
            endTime = time.time()
            totalTime2 = endTime - startTime3
            totalTime = endTime - startTime
            rateTime = endTime - startTime2
            board.sonar_read(triggerPin)
            board.sonar_read(triggerPin2)
            LDRvalue = board.analog_read(LDRpin)[0]
            temperature = calculate_temperature() 

            global buttonValue

            if buttonValue is not None:
                tempPedestrainPresence = True
                pedestrainPresence = tempPedestrainPresence
                pedestrainCount.append(peButtoncount)
                peButtoncount = peButtoncount + 1
                numPresses += 1
                buttonValue = None
                board.set_pin_mode_digital_input(buttonPin,
                                                 callback=pushbutton)
                

            try:
                if latestHeight >= maxHeight:
                    print(f"Vehicle is {latestHeight}cm, so it is too high!")
                    board.set_pin_mode_digital_output(8)
                    board.digital_pin_write(8,1)
                    time.sleep(2)
                    board.digital_pin_write(8,0)
            except TypeError or ValueError:
                pass

            if totalTime2 >= 3:
                print(
                    f"\nPolling cycle time elapsed: {totalTime:.2f}\n",
                    end='\r'
                    f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n"
                )
                break
            elif rateTime >= pollingRate:
                if latestDistance is not None:
                    print(
                        f"\nPolling cycle time elapsed: {totalTime:.2f}\n",
                        end='\r'
                        f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n"
                    )
                    distanceValues.append(latestDistance)
                    timeValues.append(totalTime)
                    try:
                        speed = (distanceValues[-1] -
                                 distanceValues[-2]) / pollingRate
                        if float(speed) > 3:
                            print(
                                "VEHICLE IS GOING TOO FAST. PLEASE SLOW DOWN.")
                        else:
                            pass
                    except IndexError:
                        pass
                    startTime2 = time.time()
                    continue
            else:
                continue
    except KeyboardInterrupt:
        turnOff()
        display_main_menu()


def stage_three():
    """
        Runs when the stage begins. Displays current stage, distance, and total cycle time at the polling rate
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    global currentStage
    currentStage = 3
    mainRoadLED = "RED"
    sideRoadLED = "RED"
    pedestrianRoadLED = "RED"


    try:
        current_stage()
        stage_three_led()
        print(
            f"Main road: {mainRoadLED}\nSide road: {sideRoadLED}\nPedestrian road: {pedestrianRoadLED}\nthe following lights will be display for 30 seconds\n"
        )
        startTime2 = time.time()
        startTime3 = time.time()
        global totalTime
        global totalTime3
        global distanceValues, pedestrainPresence, pedestrainCount, peButtoncount, numPresses
        board.set_pin_mode_analog_input(LDRpin)

        while True:
            endTime = time.time()
            totalTime3 = endTime - startTime3
            totalTime = endTime - startTime
            rateTime = endTime - startTime2
            board.sonar_read(triggerPin)
            board.sonar_read(triggerPin2)
            LDRvalue = board.analog_read(LDRpin)[0]
            temperature = calculate_temperature() 

            global buttonValue

            if buttonValue is not None:
                tempPedestrainPresence = True
                pedestrainPresence = tempPedestrainPresence
                pedestrainCount.append(peButtoncount)
                peButtoncount = peButtoncount + 1
                numPresses += 1
                buttonValue = None
                board.set_pin_mode_digital_input(buttonPin,
                                                 callback=pushbutton)

            try:
                if latestHeight >= maxHeight:
                    print(f"Vehicle is {latestHeight}cm, so it is too high!")
                    board.set_pin_mode_digital_output(8)
                    board.digital_pin_write(8,1)
                    time.sleep(2)
                    board.digital_pin_write(8,0)
            except TypeError or ValueError:
                pass

            if totalTime3 >= 3:
                print(f"\nPolling cycle time elapsed: {totalTime:.2f}\n", end='\r' f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")

                break
            elif rateTime >= pollingRate:
                if latestDistance is not None:
                    print(f"\nPolling cycle time elapsed: {totalTime:.2f}\n", end='\r' f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")

                    distanceValues.append(latestDistance)
                    timeValues.append(totalTime)
                    try:
                        speed = (distanceValues[-1] -
                                 distanceValues[-2]) / pollingRate
                        if float(speed) > 3:
                            print(
                                "VEHICLE IS GOING TOO FAST. PLEASE SLOW DOWN.")
                        else:
                            pass
                    except IndexError:
                        pass
                    startTime2 = time.time()
                    continue
            else:
                continue
    except KeyboardInterrupt:
        turnOff()
        display_main_menu()


def stage_four():
    """
        Runs when the stage begins. Displays current stage, distance, and total cycle time at the polling rate
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    global currentStage
    currentStage = 4
    mainRoadLED = "RED"
    sideRoadLED = "GREEN"
    pedestrianRoadLED = "GREEN"


    try:
        current_stage()
        stage_four_led()
        print(
            f"Main road: {mainRoadLED}\nSide road: {sideRoadLED}\nPedestrian road: {pedestrianRoadLED}\nthe following lights will be display for 30 seconds\n"
        )
        startTime3 = time.time()
        startTime2 = time.time()
        global startTime
        global totalTime
        global totalTime4
        global distanceValues, pedestrainPresence, pedestrainCount, peButtoncount, numPresses
        stageFourDuration = 30
        board.set_pin_mode_analog_input(LDRpin)

        while True:
            endTime = time.time()
            totalTime4 = endTime - startTime3
            totalTime = endTime - startTime
            rateTime = endTime - startTime2
            board.sonar_read(triggerPin)
            board.sonar_read(triggerPin2)
            LDRvalue = board.analog_read(LDRpin)[0]
            temperature = calculate_temperature() 

            global buttonValue

            if buttonValue is not None:
                tempPedestrainPresence = True
                pedestrainPresence = tempPedestrainPresence
                pedestrainCount.append(peButtoncount)
                peButtoncount = peButtoncount + 1
                numPresses += 1
                buttonValue = None
                board.set_pin_mode_digital_input(buttonPin,
                                                 callback=pushbutton)
            if LDRvalue < 20:
                stageFourDuration = 10
            
            try:
                if latestHeight >= maxHeight:
                    print(f"Vehicle is {latestHeight}cm, so it is too high!")
                    board.set_pin_mode_digital_output(8)
                    board.digital_pin_write(8,1)
                    time.sleep(2)
                    board.digital_pin_write(8,0)
            except TypeError or ValueError:
                pass

            if totalTime4 >= stageFourDuration:
                print(f"\nPolling cycle time elapsed: {totalTime:.2f}\n", end='\r' f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")

                break
            elif rateTime >= pollingRate:
                if latestDistance is not None:
                    print(f"\nPolling cycle time elapsed: {totalTime:.2f}\n", end='\r' f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")

                    distanceValues.append(latestDistance)
                    timeValues.append(totalTime)
                    try:
                        speed = (distanceValues[-1] -
                                 distanceValues[-2]) / pollingRate
                        if float(speed) > 3:
                            print(
                                "VEHICLE IS GOING TOO FAST. PLEASE SLOW DOWN.")
                        else:
                            pass
                    except IndexError:
                        pass
                    startTime2 = time.time()
                    continue
            else:
                continue
    except KeyboardInterrupt:
        turnOff()
        display_main_menu()


def stage_five():
    """
        Runs when the stage begins. Displays current stage, distance, and total cycle time at the polling rate
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    pwmPinStage5 = 5
    stage_two_five_buzzer(pwmPinStage5)

    global currentStage
    currentStage = 5
    mainRoadLED = "RED"
    sideRoadLED = "YELLOW"
    pedestrianRoadLED = "GREEN"

    
    

    try:
        current_stage()
        stage_five_led()
        print(
            f"Main road: {mainRoadLED}\nSide road: {sideRoadLED}\nPedestrian road: {pedestrianRoadLED}\nthe following lights will be display for 30 seconds\n"
        )
        startTime3 = time.time()
        startTime2 = time.time()
        global startTime
        global totalTime
        global leds
        global totalTime5
        global distanceValues, pedestrainPresence, pedestrainCount, peButtoncount, numPresses
        board.set_pin_mode_analog_input(LDRpin)

        while True:
            endTime = time.time()
            totalTime5 = endTime - startTime3
            totalTime = endTime - startTime
            rateTime = endTime - startTime2
            board.sonar_read(triggerPin)
            board.sonar_read(triggerPin2)
            LDRvalue = board.analog_read(LDRpin)[0]
            temperature = calculate_temperature() 

            global buttonValue

            if buttonValue is not None:
                tempPedestrainPresence = True
                pedestrainPresence = tempPedestrainPresence
                pedestrainCount.append(peButtoncount)
                peButtoncount = peButtoncount + 1
                numPresses += 1
                buttonValue = None
                board.set_pin_mode_digital_input(buttonPin,
                                                 callback=pushbutton)
                
        
            
            try:
                if latestHeight >= maxHeight:
                    print(f"Vehicle is {latestHeight}cm, so it is too high!")
                    board.set_pin_mode_digital_output(8)
                    board.digital_pin_write(8,1)
                    time.sleep(2)
                    board.digital_pin_write(8,0)
            except TypeError or ValueError:
                pass

            if totalTime5 >= 3:
                print(f"\nPolling cycle time elapsed: {totalTime:.2f}\n", end='\r' f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")
                break
            elif rateTime >= pollingRate:
                if latestDistance is not None:
                    print(f"\nPolling cycle time elapsed: {totalTime:.2f}\n", end='\r' f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")
                    distanceValues.append(latestDistance)
                    timeValues.append(totalTime)
                    try:
                        speed = (distanceValues[-1] -
                                 distanceValues[-2]) / pollingRate
                        if float(speed) > 3:
                            print(
                                "VEHICLE IS GOING TOO FAST. PLEASE SLOW DOWN.")
                        else:
                            pass
                    except IndexError:
                        pass
                    startTime2 = time.time()
                    pass
            else:
                pass
            leds = '10000010'
            leds_on(leds)
            time.sleep(0.25)
            leds = '10010010'
            leds_on(leds)
            time.sleep(0.25) 
            continue
    except KeyboardInterrupt:
        turnOff()
        display_main_menu()


def stage_six():
    """
        Runs when the stage begins. Displays current stage, distance, and total cycle time at the polling rate
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    global currentStage
    currentStage = 6
    mainRoadLED = "RED"
    sideRoadLED = "RED"
    pedestrianRoadLED = "RED"


    try:
        current_stage()
        stage_six_led()
        print(
            f"Main road: {mainRoadLED}\nSide road: {sideRoadLED}\nPedestrian road: {pedestrianRoadLED}\nthe following lights will be display for 30 seconds\n"
        )
        startTime3 = time.time()
        startTime2 = time.time()
        global startTime
        global totalTime
        global totalTime6
        global distanceValues, pedestrainPresence, pedestrainCount, peButtoncount, numPresses
        board.set_pin_mode_analog_input(LDRpin)

        while True:
            endTime = time.time()
            totalTime6 = endTime - startTime3
            totalTime = endTime - startTime
            rateTime = endTime - startTime2
            board.sonar_read(triggerPin)
            board.sonar_read(triggerPin2)
            LDRvalue = board.analog_read(LDRpin)[0]
            temperature = calculate_temperature() 

            global buttonValue

            if buttonValue is not None:
                tempPedestrainPresence = True
                pedestrainPresence = tempPedestrainPresence
                pedestrainCount.append(peButtoncount)
                peButtoncount = peButtoncount + 1
                numPresses += 1
                buttonValue = None
                board.set_pin_mode_digital_input(buttonPin,
                                                 callback=pushbutton)
            
            try:
                if latestHeight >= maxHeight:
                    print(f"Vehicle is {latestHeight}cm, so it is too high!")
                    board.set_pin_mode_digital_output(8)
                    board.digital_pin_write(8,1)
                    time.sleep(2)
                    board.digital_pin_write(8,0)
            except TypeError or ValueError:
                pass

            if totalTime6 >= 3:
                print(f"\nPolling cycle time elapsed: {totalTime:.2f}\n", end='\r' f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")
                break
            elif rateTime >= pollingRate:
                if latestDistance is not None:
                    print(f"\nPolling cycle time elapsed: {totalTime:.2f}\n", end='\r' f"Current stage: {currentStage}\nDistance: {latestDistance} cm\nPedestrian presence: {pedestrainPresence}\nVehicle height: {latestHeight}\nLDR value: {LDRvalue}\nTemperature: {temperature:.2f} C\n")
                    distanceValues.append(latestDistance)
                    timeValues.append(totalTime)
                    try:
                        speed = (distanceValues[-1] -
                                 distanceValues[-2]) / pollingRate
                        if float(speed) > 3:
                            print(
                                "VEHICLE IS GOING TOO FAST. PLEASE SLOW DOWN.")
                        else:
                            pass
                    except IndexError:
                        pass
                    startTime2 = time.time()
                    continue
            else:
                continue
    except KeyboardInterrupt:
        turnOff()
        display_main_menu()


def output_subsystem():
    global pedestrainPresence, pedestrainCount, peButtoncount, tempPedestrainPresence, numPresses
    """
        Begins output of normal operation mode
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    while True:

        stage_one()
        stage_two()
        stage_three()
        if pedestrainPresence == True:
            stage_four()
            pedestrainPresence = False
            pedestrainCount = []
            peButtoncount = 0
            numPresses = 0
            stage_five()
            stage_six()
        else:
            stage_six()


def normal_operation_mode():
    """
        Begins taking input from ultrasonic sensor and pedestrian push button, calling on control subsystem
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    global peButtoncount
    global pedestrainCount
    global tempPedestrainPresence
    global pedestrainPresence
    global numPresses

    initialize_thermistor()  # Initialize thermistor
    numPresses = 0
    peButtoncount = 1
    pedestrainCount = []
    tempPedestrainPresence = False
    buttonPin = 7
    pedestrainPresence = False

    global triggerPin
    global echoPin
    global triggerPin2
    global echoPin2
    global LDRpin
    #TODO: set values for trigger and echo pins for second ultrasonic 
    triggerPin = 12
    echoPin = 13
    triggerPin2 = 11
    echoPin2 = 10
    LDRpin = 1
    global latestDistance
    global buttonValue
    global latestHeight
    latestDistance = None
    latestHeight = None 
    buttonValue = None
    board.set_pin_mode_sonar(triggerPin, echoPin, the_callback)
    board.set_pin_mode_sonar(triggerPin2, echoPin2, height_sensor)
    board.set_pin_mode_digital_input(buttonPin, callback=pushbutton)
    print("Entering normal operation mode")
    control_subsystem()


def seven_segment_display(ssdMessage):
    """
    Displays an unlimited character message on the seven segment display with a scrolling effect.
        Parameters:
            ssdMessage (str): The message to display.
        Returns:
            Function has no return.
    """       
    lookupDictionary = {
    "0": "1111110",
    "1": "0110000",
    "2": "1101101",
    "3": "1111001",
    "4": "0110011",
    "5": "1011011",
    "6": "1011111",
    "7": "1110000",
    "8": "1111111",
    "9": "1111011",
    "a": "1110111",
    "b": "0011111",
    "c": "1001110",
    "d": "0111101",
    "e": "1001111",
    "f": "1000111",
    "g": "1011110",
    "h": "0110111",
    "i": "0110000",
    "j": "0111000",
    "k": "0110111",
    "l": "0001110",
    "m": "1110110",
    "n": "0010101",
    "o": "0011101",
    "p": "1100111",
    "q": "1110011",
    "r": "0000101",
    "s": "1011011",
    "t": "0001111",
    "u": "0111110",
    "v": "0111110",
    "w": "0110100",
    "x": "0110111",
    "y": "0111011",
    "z": "1101101",
    "A": "1110111",
    "B": "1111111",
    "C": "1001110",
    "D": "0111101",
    "E": "1001111",
    "F": "1000111",
    "G": "1011110",
    "H": "0110111",
    "I": "0110000",
    "J": "0111000",
    "K": "0110111",
    "L": "0001110",
    "M": "1110110",
    "N": "0010101",
    "O": "1111110",
    "P": "1100111",
    "Q": "1110011",
    "R": "0100101",
    "S": "1011011",
    "T": "0001111",
    "U": "0111110",
    "V": "0011110",
    "W": "0110100",
    "X": "0110011",
    "Y": "0111011",
    "Z": "1101101",
    " ": "0000000",
    ".": "0000001",
}

    digitPins = [10, 11, 12, 13]
    segPins = [3, 4, 5, 6, 7, 8, 9]

    for pin in segPins:
        board.set_pin_mode_digital_output(pin)
    for digit in digitPins:
        board.set_pin_mode_digital_output(digit)
        board.digital_write(digit, 1)  # Turn off all digits initially

    messageLength = len(ssdMessage)
    position = 0

    while True:
        startTime6 = time.time()
        while time.time() - startTime6 < 0.5:  # Display each frame for 0.5 seconds
            for j in range(4):
                characterIndex = (position + j) % messageLength
                segments = lookupDictionary[ssdMessage[characterIndex]]
                
                for count in range(len(segments)):
                    board.digital_write(segPins[count], int(segments[count]))
                
                board.digital_write(digitPins[j], 0)
                time.sleep(0.002)
                board.digital_write(digitPins[j], 1)
        
        position = (position + 1) % messageLength  # Move to the next position


def filter_distances(distanceValues):
    """
        Generates a new list where each element is the average of consecutive pairs of elements from the input list `distance_values`.
            Parameters:
                distanceValues (list): all the distance values collected from the ultrasonic sensor at the polling rate during normal operation mode
            Returns:
                filteredList: list of the filtered (average) distance values
    """
    if not distanceValues:
        return []

    filteredList = [distanceValues[0]]

    for i in range(1, len(distanceValues)):
        average = (distanceValues[i] + distanceValues[i - 1]) / 2
        filteredList.append(average)

    return filteredList


def traffic_distance_graph(timeValues, distanceValues):
    """
        Creates a distance vs. time graph 
            Parameters:
                timeValues (list): times at which the distanceValues were collected from the ultrasonic sensor
                distanceValues (list): all the distance values collected from the ultrasonic sensor at the polling rate during normal operation mode
            Returns:
                Function has no return
    """
    filteredList = filter_distances(distanceValues)
    try:
        # Check if we have more than 20 seconds of data
        if timeValues[-1] - timeValues[0] > 20:
            # Iterate backwards to find the index where to start the slice for the last 20 seconds
            for i in range(len(timeValues) - 1):
                if timeValues[-1] - timeValues[i] <= 20:
                    start_index = i
                    break
            x = timeValues[start_index:]
            y = filteredList[start_index:]
        else:
            x = timeValues
            y = filteredList

        plt.plot(x, y)

        # Set x-ticks to show only the last 20 seconds
        plt.xticks(range(int(min(x)), int(max(x)) + 1), rotation=45)

        plt.xlabel('Time (s)')
        plt.ylabel('Distance (cm)')
        plt.title('Traffic Distance Graph - Last 20 seconds')
        plt.grid(True)  #  Add a grid for better readability
        # Save the graph with a logical filename using time
        timestr = time.strftime("%Y%m%d-%H%M%S")
        filename = f"traffic_distance_graph_{timestr}.png"
        plt.savefig(filename)
        print(f"Graph saved as: {filename}")

        plt.show()
    except IndexError:
        print(
            "Insufficient data! More data is required in order to plot a graph."
        )


def data_observation_mode(timeValues, distanceValues):
    """
        calls on traffic_distance_graph() and seven_segment_display()
            Parameters:
                timeValues (list): times at which the distanceValues were collected from the ultrasonic sensor
                distanceValues (list): all the distance values collected from the ultrasonic sensor at the polling rate during normal operation mode
            Returns:
                Function has no return
    """
    print("Entering data observation mode...\n")
    try:
        while True:
            print(
                "\n1. Display traffic distance graph \n2. Display seven segment display\n"
            )
            choice = input(
                "From the options above choose what information you would like to see (1,2):"
            )
            try:
                choice = int(str(choice))
            except ValueError:
                print("\ninvalid input, please try again!")
                continue
            if choice == 1:
                traffic_distance_graph(timeValues, distanceValues)
            elif choice == 2:
                seven_segment_display(ssdMessage)
            else:
                print("invalid input, please try again!")
                continue
    except KeyboardInterrupt:
        display_main_menu()


def maintenance_adjustment_mode():
    """
        calls on pin_checl and parameter_adjustment
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    pin_check2()
    parameter_adjustment()
    # mam_flashing()
    access_timeout()


def parameter_adjustment():
    """
        Where the user can change the pin, polling rate and message displayed on the seven segment display
            Parameters:
                Function has no parameters
            Returns:
                Function has no return
    """
    global savedPin
    global pollingRate

    while True:
        try:
            print(
                "Enter the parameter that needs to be changed from the following:"
            )
            print("1. Update PIN")
            print("2. Polling Rate")
            print("3. Seven Segment Display")
            print("4. Maximum height")
            print("5. Quit")
            option = int(input("Enter your choice: "))

            if option == 1:
                while True:
                    newPin = input("\nEnter a new PIN (4 digits): ")
                    if newPin.isdigit() and len(newPin) == 4:
                        savedPin = newPin
                        print("\nPIN updated successfully.\n")
                        break
                    else:
                        print(
                            "\nInvalid PIN. Please enter exactly 4 digits.\n")
                        continue
            elif option == 2:
                while True:
                    newRate = float(
                        input("\nEnter a new polling rate (1-5 seconds): "))
                    if 1 <= newRate <= 5:
                        pollingRate = newRate
                        print("\nPolling Rate updated successfully.\n")
                        break
                    else:
                        print(
                            "\nInvalid rate. Please enter a value between 1 and 5.\n"
                        )
                        continue
            elif option == 3:
                while True:
                    global ssdMessage
                    ssdMessage = input(
                        "\nEnter a new message for Seven Segment Display: ")
                    print(
                            "\nSeven Segment Display message updated successfully.\n"
                        )
                    break
            elif option == 4:
                while True:
                    global maxHeight
                    try:
                        maxHeight = float(input("\nEnter a new maximum vehicle height: "))
                        print("\n Maximum height updated successfuly.\n")
                        break
                    except ValueError:
                        print("\nInvalid height. Please enter a valid number.\n")
                        continue 
            elif option == 5:
                print("\nReturning to main menu.")
                display_main_menu()
                break
            else:
                print("\nInvalid option. Please choose a valid option.\n")
        except ValueError:
            print("\nInvalid input. Please try again.\n")
        except KeyboardInterrupt:
            print("\nReturning to Main Menu...")
            display_main_menu()
            break


display_main_menu()
