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

                            <div class="form-group row">
                                <div class="col-sm-2 control-label">
                                    <h3 class="text-info">Kontaktdaten</h3>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="anrede" class="col-sm-2 control-label">Anrede</label>
                                <select class="col-xs-3" id="anrede" name="anrede">
                                    <option>Herr</option>
                                    <option>Frau</option>
                                </select>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 control-label">Name *</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="name" name="name" value="{//form/field[@name='name']/value}" placeholder="Name"/>
                                </div>
                                <div class="text has-error">
                                    <xsl:if test="//form/field[@name='name']/error != ''">
                                        <small class="help-block"><xsl:value-of select="//form/field[@name='name']/error"/></small>
                                     </xsl:if>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="vorname" class="col-sm-2 control-label">Vorname *</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="vorname" name ="vorname" value="{//form/field[@name='vorname']/value}" placeholder="Vorname"/>
                                </div>
                                <div class="text has-error">
                                    <xsl:if test="//form/field[@name='vorname']/error != ''">
                                        <small class="help-block"><xsl:value-of select="//form/field[@name='vorname']/error"/></small>
                                    </xsl:if>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="strasse" class="col-sm-2 control-label">Strasse *</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="strasse" name="strasse" value="{//form/field[@name='strasse']/value}" placeholder="Strasse"/>
                                </div>
                                <div class="text has-error">
                                    <xsl:if test="//form/field[@name='strasse']/error != ''">
                                        <small class="help-block"><xsl:value-of select="//form/field[@name='strasse']/error"/></small>
                                    </xsl:if>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="plz" class="col-sm-2 control-label">PLZ *</label>
                                <div class="col-xs-1">
                                    <input type="text" class="form-control" id="plz" name="plz" value="{//form/field[@name='plz']/value}" placeholder="PLZ"/>
                                </div>
                                <div class="text has-error">
                                    <xsl:if test="//form/field[@name='plz']/error != ''">
                                        <small class="help-block"><xsl:value-of select="//form/field[@name='plz']/error"/></small>
                                    </xsl:if>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ort" class="col-sm-2 control-label">Ort *</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="ort" name="ort" value="{//form/field[@name='ort']/value}" placeholder="Ort"/>
                                </div>
                                <div class="text has-error">
                                    <xsl:if test="//form/field[@name='ort']/error != ''">
                                        <small class="help-block"><xsl:value-of select="//form/field[@name='ort']/error"/></small>
                                    </xsl:if>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 control-label">Telefon Nummer</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="phone" name="phone" value="{//form/field[@name='phone']/value}" placeholder="Telefon"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 control-label">E-Mail Adresse *</label>
                                <div class="col-xs-3">
                                    <input type="email" class="form-control" id="email" name="email" value="{//form/field[@name='email']/value}" placeholder="Email"/>
                                </div>
                                <div class="text has-error">
                                    <xsl:if test="//form/field[@name='email']/error != ''">
                                        <small class="help-block"><xsl:value-of select="//form/field[@name='email']/error"/></small>
                                    </xsl:if>
                                </div>
                            </div>

                        <div class="form-group row">
                            <div class="col-sm-2 control-label">
                                <h3 class="text-info">Tickets</h3>
                            </div>
                        </div>

                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Sportart</label>
                                <div class="col-xs-3">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sportart" id="sportart1" value="Fussball" >
                                                <xsl:if test="//form/field[@name='sportart']/value = 'Fussball'">
                                                    <xsl:attribute name="checked">checked</xsl:attribute></xsl:if>
                                            </input>
                                            Fussball
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sportart" id="sportar2t" value="Handball" >
                                                <xsl:if test="//form/field[@name='sportart']/value = 'Handball'">
                                                    <xsl:attribute name="checked">checked</xsl:attribute></xsl:if>
                                            </input>
                                            Handball
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sportart" id="sportart3" value="Volleyball" >
                                                <xsl:if test="//form/field[@name='sportart']/value = 'Volleyball'">
                                                    <xsl:attribute name="checked">checked</xsl:attribute></xsl:if>
                                            </input>
                                            Volleyball
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="text has-error">
                                <xsl:if test="//form/field[@name='sportart']/error != ''">
                                    <small class="help-block"><xsl:value-of select="//form/field[@name='sportart']/error"/></small>
                                </xsl:if>
                            </div>

                            <div class="form-group row">
                                <label for="anzahl" class="col-sm-2 control-label">Anzahl Tickets *</label>
                                <div class="col-xs-3">
                                    <input type="text" class="form-control" id="anzahl" name="anzahl" value="{//form/field[@name='anzahl']/value}" placeholder="Anzahl"/>
                                </div>
                                <div class="text has-error">
                                    <xsl:if test="//form/field[@name='anzahl']/error != ''">
                                        <small class="help-block"><xsl:value-of select="//form/field[@name='anzahl']/error"/></small>
                                    </xsl:if>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">Bestellung ausführen</button>
                                </div>
                            </div>

                        <xsl:if test="//form/field[@name='message']/value != ''">
                            <div class="col-sm-offset-2 col-sm-10">
                                <p class="text-success"> Success! <xsl:value-of select="//form/field[@name='message']/value" /></p>
                            </div>
                        </xsl:if>

                    </form>

                </section>
            </div>

        </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
