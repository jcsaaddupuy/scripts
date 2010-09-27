#!/usr/bin/env ruby
#Based on the script from the book "Wicked cool ruby scripts" by Steve Pugh

#If no argument given
unless ARGV[0]
	puts "Usage : #{__FILE__} <filename(s)>"
	exit
end

#For each file given
ARGV.each do | fname |
	old_filename=fname

	#Check if file exists
	unless File.exist?(old_filename)
		puts "#{old_filename} doesn't exists"
		exit
	end

	name=File.basename(old_filename, ".*")
	oldname=name.clone
	ext=File.extname(old_filename)
	dir=File.expand_path(old_filename)
	dir=dir[0,dir.rindex(name)]

	replacements={
		/;/=> "-",
		/\s/=> "_",
		/\&/=> "_and_",
		/\$/ => "_dollar_",
		/\€/ => "_euro_",
		/\%/ => "_percent_",
		/[\(\)\[\]<>\{\}]/ => "",
		/:/ => "",
		/\+/ => "plus",
		/'/ => "_"
	}

	#Replace all invalids char
	replacements.each do |orig, fix|
		name.gsub!(orig,fix)
	end

	#Drop unnecessary underscores (leave only one when multiples "_" are encountered)
	name.gsub!(/_+/,"_")

	#Drop the last underscore if present	
	if name.end_with?("_")
		name=name[0,name.length-1]
	end

	#Downcase the extension
	if  (! nil.equal?(ext) && ext != "")
		ext=ext.downcase
	end

	#If the filename is differents than the origin, we rename the file.
	if name != oldname
		new_filename=dir + name + ext.downcase
		File.rename(old_filename, new_filename)
		puts "#{old_filename} ---> #{new_filename}"
	end

end
