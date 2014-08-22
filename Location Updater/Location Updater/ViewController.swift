//
//  ViewController.swift
//  Location Updater
//
//  Created by Dan Cuddeford on 8/22/14.
//  Copyright (c) 2014 Dan cuddeford. All rights reserved.
//

import UIKit
import CoreLocation


class ViewController: UIViewController, CLLocationManagerDelegate {
    
    var currentLat : NSString = "0"
    var currentLong : NSString = "0"
    var myDate = NSDate()
    var myTimer: NSTimer? = nil

    
    @IBOutlet weak var label1: UILabel!
    
    @IBOutlet weak var label2: UILabel!
    
    var locationManager: CLLocationManager!

    override func viewDidLoad() {
        super.viewDidLoad()
        
        locationManager = CLLocationManager()
        locationManager.delegate = self
        locationManager.desiredAccuracy = kCLLocationAccuracyBest
        
        locationManager.pausesLocationUpdatesAutomatically = false
        locationManager.startUpdatingLocation()
        
        label1.text = "waiting on location"
        label1.sizeToFit()
        
        label2.text = "waiting on location"
        label2.sizeToFit()
        
        let myTimer = NSTimer(timeInterval: 20, target: self, selector: "callwebservice", userInfo: nil, repeats: true)
        NSRunLoop.currentRunLoop().addTimer(myTimer, forMode: NSRunLoopCommonModes)

        
        // Do any additional setup after loading the view, typically from a nib.
    }
    
    func locationManager(manager: CLLocationManager!, didUpdateLocations locations: [AnyObject]!) {
        var coord = (locations[0].coordinate)
        
        
        
        
        label1.text = (String(format: "%@%.5f", "", coord.latitude))
        currentLat = (String(format: "%@%.5f", "", coord.latitude))
        label1.sizeToFit()
        label2.text = (String(format: "%@%.5f", "", coord.longitude))
        currentLong = (String(format: "%@%.5f", "", coord.longitude))
        label2.sizeToFit()
        
        var timeSinceNow = myDate.timeIntervalSinceNow
        
        
        NSThread.sleepForTimeInterval(0.001)
        print("location updated")
        println(timeSinceNow)
        
    }
    
    
    func callwebservice()
    {
        webservicesend(currentLong, lat: currentLat)
        
        
    }
    
    func webservicesend(long:NSString, lat:NSString) {
        
        
        var url =  NSURL.URLWithString("http://ec2-54-164-79-90.compute-1.amazonaws.com/updatelocation.php?long=\(long)&lat=\(lat)")
        
        var request = NSURLRequest(URL: url as NSURL)
        
        
        var conn = NSURLConnection(request: request, delegate: self, startImmediately: true)
        
        println("Ran web service send")
    }


    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }


}

