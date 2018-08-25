; <?php die(); ?>

[General]
    filter_type     = xml

    base_path       = ../../src/IDS/
    use_base_path   = false

    filter_path     = ../../src/IDS/default_filter.xml
    tmp_path        = /tmp
    scan_keys       = false

    HTML_Purifier_Cache = vendors/htmlpurifier/HTMLPurifier/DefinitionCache/Serializer

    exceptions[]    = GET.__utmz
    exceptions[]    = GET.__utmc

[Caching]
    caching         = none
