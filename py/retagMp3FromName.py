# -*- coding: utf8 -*-

'''
A (very) quick and dirty script to retag all songs from an album.
As there was just the title to reset, and files where well named, it justs split
the filename and set the title.
'''

import eyeD3
import os

DIR="/home/jc/jack/sons/Parabellum/Parabellum L'intégrale Vol1"
files=os.listdir(DIR)

for file in files :
	title, _ =file.split(".mp3")
	print "File title : ", title
	
	tag = eyeD3.Tag()
        tag.link(DIR+"/"+file)
	print "Old tag : '",tag.getTitle(), "' new tag : '",title,"'"
	tag.setTitle(title)
	tag.update()
