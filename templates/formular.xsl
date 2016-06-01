<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output
            method="html"
            doctype-public="XSLT-compat"
            omit-xml-declaration="yes"
            encoding="UTF-8"
            indent="yes" />

    <xsl:template match="/">
        <html>
            <head>

                <title>Formularbearbeitung</title>
                <meta charset="utf-8" />
                <title>Sport-Tickets</title>
                <!-- Bootstrap -->
                <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
            </head>
        <body>

            <div id="wrapper">
                <header>
                    <h1> Sport-Tickets bestellen </h1>
                </header>

                <section>

                    <form class="form-horizontal" action="/proccessForm.php" method="post">

                        <div class="form-group">
                            <label for="anrede" class="col-sm-2 control-label">Anrede</label>
                            <select class="col-xs-4" id="anrede">
                                <option>Herr</option>
                                <option>Frau</option>
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name"/>
                            </div>
                            <xsl:if test="//formError/field[@id='name'] != ''">
                                <p>Fehler! <xsl:value-of select="//formError/field[@id='name']" /></p>
                            </xsl:if>
                        </div>

                        <div class="form-group">
                            <label for="vorname" class="col-sm-2 control-label">Vorname</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="vorname" placeholder="Vorname"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="strasse" class="col-sm-2 control-label">Strasse</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="strasse" placeholder="Strasse"/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="plz" class="col-sm-2 control-label">PLZ</label>
                            <div class="col-xs-1">
                                <input type="text" class="form-control" id="plz" placeholder="PLZ"/>
                            </div>

                            <label for="ort" class="col-sm-2 control-label">Ort</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="ort" placeholder="Ort"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phpne" class="col-sm-2 control-label">Telefon Nummer</label>
                            <div class="col-xs-4">
                                <input type="text" class="form-control" id="phpne" placeholder="Telefon"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">E-Mail Adresse</label>
                            <div class="col-xs-4">
                                <input type="email" class="form-control" id="email" placeholder="Email"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">Bestellung ausführen</button>
                            </div>
                        </div>
                    </form>

                </section>
            </div>

        </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
