# Working under `Twenty Ten` wordpress theme
require 'open-uri'
require 'nokogiri'
require 'json'

class News
  attr_accessor :title, :tags, :author, :date, :text
  
  def to_s
    puts @title
    puts @tags
    puts @author
    puts @date
    puts @text
  end
end

class Category
  attr_accessor :id, :tags

  def to_s
    puts @id
    puts @tags
  end
end

class String
  def fix_date
    months = [
      '',
      'gennaio',
      'febbraio',
      'marzo',
      'aprile',
      'maggio',
      'giugno',
      'luglio',
      'agosto',
      'settembre',
      'ottobre',
      'novembre',
      'dicembre'
    ]
    
    s = self.split ' '
    "#{s[0]}/#{months.index(s[1])}/#{s[2]}"
  end
end 

db = []
categories = []

3.downto(1) { |page|
  Nokogiri::HTML(open("http://www.omnivium.it/page/#{page}")).xpath('//h2[@class="entry-title"]/a/@href').reverse.each { |a|
    omnivium = Nokogiri::HTML(open(a))
    db << {}.tap { |news|
      news[:title]  = omnivium.xpath('//h1[@class="entry-title"]').text
      news[:tags]   = ''.tap { |tags| omnivium.xpath('//a[@rel="category tag"]').each { |tag| tags << tag.text + ', ' } }[0..-3]
      news[:author] = omnivium.xpath('//span[@class="author vcard"]/a').text
      news[:date]   = omnivium.xpath('//span[@class="entry-date"]').text.fix_date
      news[:text]   = omnivium.xpath('//div[@class="entry-content"]').to_s.split('<h3>Share and Enjoy')[0]
    }
  }
}

i = 1
db.each { |news|
  next if news[:title].include? '[Fate'
  next if news[:title].include? 'Riorganizzazione'
  File.open("#{i}.json", ?w) { |f| f.write news.to_json }
  categories << { :id => i.to_s, :tags => news[:tags] }
  i += 1
}

File.open("categories.json", ?w) { |f| f.write categories.to_json }
