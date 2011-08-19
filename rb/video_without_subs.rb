#!/usr/bin/env ruby

require 'find'

$known_movie_ext=['.avi',]
$known_subs_ext=['.srt', '.sub']

def has_subs(file)
    $known_subs_ext.each do |srt_ext|
        subfile_name = file.gsub(File.extname(file),srt_ext)
        if File.exists?(subfile_name)
            return true
        end
    end
    return false
end

def isMedia(file)
    fext = File.extname(file)
    return $known_movie_ext.include? fext 
end


def findVideoWithoutSubs(folder)
    Find.find(folder){ |f|
    if isMedia(f) and not has_subs(f)
        puts f
    end
    }
end

t_path=ARGV[0]


findVideoWithoutSubs t_path
