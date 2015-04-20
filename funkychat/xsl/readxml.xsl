<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/TR/REC-html40">
	<xsl:output method="html" encoding="ISO-8859-1" indent="yes"/>
	<xsl:template match="rss/channel">
		<xsl:for-each select="item">
			<div>
				<xsl:attribute name="class">
						<xsl:choose>
			        	<xsl:when test="position() mod 2 = 0">linerow_2</xsl:when>
			        	 <xsl:otherwise>linerow_1</xsl:otherwise>
			        </xsl:choose>
				</xsl:attribute>
				<!-- [ <xsl:value-of select="datetime" disable-output-escaping="yes"/> ] --> <b><xsl:value-of select="nick"/></b> &gt; <xsl:value-of select="title" disable-output-escaping="yes"/>
			</div>
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>