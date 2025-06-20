import feedparser

def generate_html(rss_content, output_file):
    feed = feedparser.parse(rss_content)
    items = feed.entries

    with open(output_file, 'w', encoding='utf-8') as file:
        file.write('<!DOCTYPE html>\n<html>\n<head>\n')
        file.write('<meta charset="UTF-8">\n')
        file.write('<meta name="viewport" content="width=device-width, initial-scale=1.0">\n')
        file.write('<title>RSS Feed to HTML</title>\n')
        file.write('<style>\n')
        file.write('body { font-family: Arial, sans-serif; margin: 0; padding: 0; }\n')
        file.write('header { background-color: #333; color: white; text-align: center; padding: 1rem 0; }\n')
        file.write('.news-item { margin: 2rem; }\n')
        file.write('.news-title { color: #007BFF; text-decoration: none; font-weight: bold; }\n')
        file.write('.news-description { margin: 0.5rem 0; }\n')
        file.write('</style>\n')
        file.write('</head>\n<body>\n')
        file.write('<header>\n<h1>RSS Feed to HTML</h1>\n</header>\n')

        for item in items:
            title = item.title
            link = item.link
            description = item.description
            file.write('<div class="news-item">\n')
            file.write(f'<a class="news-title" href="{link}">{title}</a>\n')
            file.write(f'<p class="news-description">{description}</p>\n')
            file.write('</div>\n')

        file.write('</body>\n</html>\n')

if __name__ == "__main__":
    rss_content = """
    <rss xmlns:dc="http://purl.org/dc/elements/1.1/" version="2.0">
<channel>
<title>Document Repository</title>
<link>http://wedocs.unep.org:80</link>
<description>The UN Environment Document Repository digital repository system captures, stores, indexes, preserves, and distributes digital research material.</description>
<pubDate xmlns="http://apache.org/cocoon/i18n/2.1">Wed, 23 Aug 2023 12:13:27 GMT</pubDate>
<dc:date>2023-08-23T12:13:27Z</dc:date>
<item>
<title>Asia Pacific Regional Meeting of the Second Ad hoc open-ended working group (OEWG 2) on a science-policy panel to contribute further to the sound management of chemicals and waste and to prevent pollution 7 September 2023</title>
<link>https://wedocs.unep.org/20.500.11822/43176</link>
<description>Asia Pacific Regional Meeting of the Second Ad hoc open-ended working group (OEWG 2) on a science-policy panel to contribute further to the sound management of chemicals and waste and to prevent pollution 7 September 2023 United Nations Environment Programme </description>
<pubDate>Sat, 01 Jul 2023 00:00:00 GMT</pubDate>
<guid isPermaLink="false">https://wedocs.unep.org/20.500.11822/43176</guid>
<dc:date>2023-07-01T00:00:00Z</dc:date>
</item>
<item>
<title>The Ozone Treaties</title>
<link>https://wedocs.unep.org/20.500.11822/43175</link>
<description>The Ozone Treaties United Nations Environment Programme </description>
<pubDate>Tue, 22 Aug 2023 00:00:00 GMT</pubDate>
<guid isPermaLink="false">https://wedocs.unep.org/20.500.11822/43175</guid>
<dc:date>2023-08-22T00:00:00Z</dc:date>
</item>
<item>
<title>CITES Governing structures</title>
<link>https://wedocs.unep.org/20.500.11822/43174</link>
<description>CITES Governing structures United Nations Environment Programme </description>
<pubDate>Tue, 22 Aug 2023 00:00:00 GMT</pubDate>
<guid isPermaLink="false">https://wedocs.unep.org/20.500.11822/43174</guid>
<dc:date>2023-08-22T00:00:00Z</dc:date>
</item>
<item>
<title>Chapter 1: Africa's Development in the Context of Air Pollution and Climate Change - Integrated Assessment of Air Pollution and Climate Change for Sustainable Development in Africa</title>
<link>https://wedocs.unep.org/20.500.11822/43173</link>
<description>Chapter 1: Africa's Development in the Context of Air Pollution and Climate Change - Integrated Assessment of Air Pollution and Climate Change for Sustainable Development in Africa United Nations Environment Programme; African Union This chapter examines how the aspirations articulated in Agenda 2030 and Agenda 2063 can be met without compromising air quality and human health, and in a way that is compatible with the Paris Agreement, limiting the increase in temperature and damage associated with climate change. Of importance is the analysis of implications of current and projected policies and measures with respect to human vulnerability to environmental degradation, climate change and intergenerational, gender and youth aspects of development. </description>
<pubDate>Tue, 01 Aug 2023 00:00:00 GMT</pubDate>
<guid isPermaLink="false">https://wedocs.unep.org/20.500.11822/43173</guid>
<dc:date>2023-08-01T00:00:00Z</dc:date>
</item>
</channel>
</rss>
(() => { window.addoncropExtensions = window.addoncropExtensions || []; window.addoncropExtensions.push({ mode: 'emulator', emulator: 'Foxified', extension: { id: 44, name: 'YouTube Downloader by Addoncrop', version: '17.2.8', date: 'August 11, 2023', }, flixmateConnected: false, }); })();
    """
    output_file = input("Enter the output HTML file name (e.g., output.html): ")
    generate_html(rss_content, output_file)
    print(f"HTML file '{output_file}' generated successfully.")
