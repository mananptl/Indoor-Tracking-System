# Indoor Tracking System

IoT-Based Indoor Tracking System using ESP32, BLE, RSSI and LoRa Communication.

---

# Project Overview

The Indoor Tracking System is designed to provide real-time location tracking inside buildings where GPS signals are weak or unavailable. The system uses Bluetooth Low Energy (BLE) signal broadcasting, RSSI-based positioning, ESP32 nodes, and LoRa communication to detect and monitor devices within indoor environments.

The project combines embedded systems, wireless communication, backend processing, and web dashboard visualization to create a scalable and cost-effective indoor tracking solution.

---

# Objectives

- Develop a real-time indoor tracking system
- Detect BLE devices using ESP32 nodes
- Estimate device location using RSSI values
- Implement multi-node confirmation for improved accuracy
- Display live tracking data on a web dashboard
- Store historical tracking records in database
- Provide scalable and low-cost indoor positioning solution

---

# Key Features

- Real-time indoor tracking
- BLE signal detection
- RSSI-based positioning
- Multi-node location confirmation
- LoRa communication between nodes and server
- Live dashboard visualization
- Search and filtering support
- Historical tracking data
- JSON backup support
- Multi-device tracking support

---

# Hardware Components

- ESP32 Microcontroller
- SX1278 (Ra-02) LoRa Module
- BLE-enabled mobile devices
- Wi-Fi Network
- Server System

---

# Software Technologies

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- Arduino IDE
- XAMPP Server

---

# System Architecture

The system consists of multiple ESP32 nodes placed in different indoor locations. BLE devices continuously broadcast signals which are detected by nearby ESP32 nodes.

The nodes:
1. Scan BLE signals
2. Measure RSSI values
3. Send data using LoRa communication
4. Server processes RSSI values
5. Dashboard displays device location

---

# Working Principle

1. BLE devices broadcast signals
2. ESP32 nodes detect nearby signals
3. RSSI values are collected
4. LoRa modules transmit data to server
5. PHP backend processes location data
6. Database stores tracking information
7. Dashboard displays live location updates

---

# Tracking Algorithm

The system uses RSSI averaging and multi-node confirmation logic for location detection.

Algorithm Flow:
- RSSI Data Collection
- RSSI Averaging
- Weak Signal Filtering
- Room Grouping
- Multi-node Confirmation
- Stability Checking
- Final Location Selection

This approach improves stability and reduces sudden incorrect location changes.

---

# Dashboard Features

- Live tracking mode
- Device search functionality
- Zone-based filtering
- Real-time data updates
- Historical data monitoring
- Structured table visualization

---

# Database Features

- Real-time data storage
- Historical tracking records
- Fast query processing
- JSON backup support
- Efficient data retrieval

---

# Performance Analysis

| Parameter | Performance |
|---|---|
| Response Time | Fast |
| Accuracy | Good |
| Stability | High |
| Scalability | High |
| Data Processing | Efficient |

---

# Advantages

- Real-time tracking
- Low-cost implementation
- Scalable architecture
- Reliable LoRa communication
- Multi-device support
- User-friendly dashboard
- Efficient backend processing

---

# Limitations

- RSSI signal fluctuation
- Dependency on node placement
- Room-level accuracy only
- Signal interference
- Small movement delay

---

# Applications

- Schools and Colleges
- Hospitals
- Offices
- Shopping Malls
- Warehouses
- Mining Areas
- Emergency Shelters
- GPS-denied Environments

---

# Future Scope

Future improvements can include:

- Ultra-Wideband (UWB) integration
- Map-based visualization
- Mobile application development
- Cloud-based deployment
- Smart alert system
- Data analytics and reporting
- Power optimization

---

# Screenshots

## Dashboard Interface

![Dashboard](Images/dashboard.png)

---

# Tools and Platforms

- Arduino IDE
- XAMPP Server
- MySQL Database
- nRF Connect Application
- GitHub

---

# References

- ESP32 Official Documentation
- Arduino Documentation
- PHP Documentation
- MySQL Documentation
- MDN Web Docs
- IEEE Research Papers on Indoor Localization

---

# Author

## Manan Patel

Diploma in Computer Engineering  
Vidhyadeep University

---

# Conclusion

The proposed Indoor Tracking System successfully demonstrates a practical and scalable solution for indoor location tracking using BLE, RSSI, ESP32, and LoRa technology. The system provides reliable room-level tracking, real-time monitoring, and efficient backend processing while maintaining low implementation cost.
