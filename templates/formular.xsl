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

                    <form class="form-horizontal" action="/processForm.php" method="post">

                        <h3>Kontaktdaten</h3>

                            <div class="form-group row">
                                <label for="anrede" class="col-sm-2 control-label">Anrede</label>
                                <select class="col-xs-3" id="anrede">
                                    <option>Herr</option>
                                    <option>Frau</option>
                                </select>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 control-label">Name *</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name"/>
                                </div>
                                <xsl:if test="//formError/field[@name='name'] != ''">
                                    <p>Fehler! <xsl:value-of select="//formError/field[@name='name']" /></p>
                                </xsl:if>
                            </div>

                            <div class="form-group row">
                                <label for="vorname" class="col-sm-2 control-label">Vorname *</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="vorname" name ="vorname" placeholder="Vorname"/>
                                </div>
                                <xsl:if test="//formError/field[@name='vorname'] != ''">
                                    <p>Fehler! <xsl:value-of select="//formError/field[@name='vorname']" /></p>
                                </xsl:if>
                            </div>

                            <div class="form-group row">
                                <label for="strasse" class="col-sm-2 control-label">Strasse *</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="strasse" name="strasse" placeholder="Strasse"/>
                                </div>
                                <xsl:if test="//formError/field[@name='strasse'] != ''">
                                    <p>Fehler! <xsl:value-of select="//formError/field[@name='strasse']" /></p>
                                </xsl:if>
                            </div>


                            <div class="form-group row">
                                <label for="plz" class="col-sm-2 control-label">PLZ *</label>
                                <div class="col-xs-1">
                                    <input type="text" class="form-control" id="plz" name="plz" placeholder="PLZ"/>
                                </div>
                                <xsl:if test="//formError/field[@name='plz'] != ''">
                                    <p>Fehler! <xsl:value-of select="//formError/field[@name='plz']" /></p>
                                </xsl:if>
                            </div>

                            <div class="form-group row">
                                <label for="ort" class="col-sm-2 control-label">Ort *</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="ort" name="ort" placeholder="Ort"/>
                                </div>
                                <xsl:if test="//formError/field[@name='ort'] != ''">
                                    <p>Fehler! <xsl:value-of select="//formError/field[@name='ort']" /></p>
                                </xsl:if>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 control-label">Telefon Nummer</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefon"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 control-label">E-Mail Adresse *</label>
                                <div class="col-xs-3">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email"/>
                                </div>
                                <xsl:if test="//formError/field[@name='email'] != ''">
                                    <p>Fehler! <xsl:value-of select="//formError/field[@name='email']" /></p>
                                </xsl:if>
                            </div>

                        <h3>Tickets</h3>

                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Sportart</label>
                                <div class="col-xs-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sportart" id="sportart1" value="fussball"/>
                                            Fussball
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sportart" id="sportar2t" value="handball"/>
                                            Handball
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sportart" id="sportart3" value="volleyball"/>
                                            Volleyball
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <xsl:if test="//formError/field[@name='sportart'] != ''">
                                <p>Fehler! <xsl:value-of select="//formError/field[@name='sportart']" /></p>
                            </xsl:if>

                            <div class="form-group row">
                                <label for="anzahl" class="col-sm-2 control-label">Anzahl Tickets *</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="anzahl" name="anzahl" placeholder="Anzahl"/>
                                </div>
                                <xsl:if test="//formError/field[@name='anzahl'] != ''">
                                    <p>Fehler! <xsl:value-of select="//formError/field[@name='anzahl']" /></p>
                                </xsl:if>
                            </div>


                            <div class="form-group row">
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
