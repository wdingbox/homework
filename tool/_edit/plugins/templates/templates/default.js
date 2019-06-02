/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.addTemplates('default',{imagesPath:CKEDITOR.getUrl(CKEDITOR.plugins.getPath('templates')+'templates/images/'),templates:[{title:'Image and Title',image:'template1.gif',description:'One main image with a title and text that surround the image.',html:'<h3><img style="margin-right: 10px" height="100" width="100" align="left"/>Type the title here</h3><p>Type the text here</p>'},{title:'Strange Template',image:'template2.gif',description:'A template that defines two colums, each one with a title, and some text.',html:'<table cellspacing="0" cellpadding="0" style="width:100%" border="0"><tr><td style="width:50%"><h3>Title 1</h3></td><td align="center"></td><td style="width:50%"><h3>Title 2</h3></td></tr><tr><td align="center">Text 1</td><td align="center"></td><td align="center">Text 2</td></tr></table><p>More text goes here.</p>'},{title:'Text and Table',image:'template3.gif',description:'A title with some text and a table.',html:'<div style="width: 80%"><h3>Title goes here</h3><table style="width:150px;float: right" cellspacing="0" cellpadding="0" border="1"><caption style="border:solid 1px black"><strong>Table title</strong></caption></tr><tr><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td></tr><tr><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td></tr><tr><td align="center">&nbsp;</td><td align="center">&nbsp;</td><td align="center">&nbsp;</td></tr></table><p>Type the text here</p></div>'},

{title:'Weid Flow-Chart-1',image:'template3.gif',description:'A title with some text and a table.',
html:

'<div style="width: 80%;">                                                                                                                  '+
'			<h3>                                                                                                                '+
'				Title goes here</h3>                                                                                        '+
'			<p>                                                                                                                 '+
'				Type the text here</p>                                                                                      '+
'			<table align="center" border="1" cellpadding="1" cellspacing="1" id="t1" style="width: 500px;" summary="summ">      '+
'				<caption>                                                                                                   '+
'					Flow-Chart Diagram</caption>                                                                        '+
'				<thead>                                                                                                     '+
'					<tr>                                                                                                '+
'						<th scope="col">                                                                            '+
'							&nbsp;</th>                                                                         '+
'						<th scope="col">                                                                            '+
'							&nbsp;</th>                                                                         '+
'						<th scope="col">                                                                            '+
'							&nbsp;</th>                                                                         '+
'						<th scope="col">                                                                            '+
'							&nbsp;</th>                                                                         '+
'						<th scope="col">                                                                            '+
'							&nbsp;</th>                                                                         '+
'						<th scope="col">                                                                            '+
'							&nbsp;</th>                                                                         '+
'						<th scope="col">                                                                            '+
'							&nbsp;</th>                                                                         '+
'					</tr>                                                                                               '+
'				</thead>                                                                                                    '+
'				<tbody>                                                                                                     '+
'					<tr>                                                                                                '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							<div align="center" style="width: 80%;">                                            '+
'								<h3>                                                                        '+
'									Title goes here</h3>                                                '+
'								<p>                                                                         '+
'									Type the text here</p>                                              '+
'							</div>                                                                              '+
'						</td>                                                                                       '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'					</tr>                                                                                               '+
'					<tr>                                                                                                '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'					</tr>                                                                                               '+
'					<tr>                                                                                                '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'					</tr>                                                                                               '+
'					<tr>                                                                                                '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'					</tr>                                                                                               '+
'					<tr>                                                                                                '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'					</tr>                                                                                               '+
'					<tr>                                                                                                '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'					</tr>                                                                                               '+
'					<tr>                                                                                                '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'					</tr>                                                                                               '+
'					<tr>                                                                                                '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'						<td align="center">                                                                                        '+
'							&nbsp;</td>                                                                         '+
'					</tr>                                                                                               '+
'				</tbody>                                                                                                    '+
'			</table>                                                                                                            '+
'		</div>                                                                                                                      '+
'		<p>                                                                                                                         '+
'			notes hers</p>                                                                                                      '+
' '

},




{title:'Weid TBI Ananlysis Process Flow-Chart',image:'template3.gif',description:'A title with some text and a table.',
html:

'<table border="1" cellpadding="1" cellspacing="1" style="width: 500px;" summary="To find the core of words">                           '+
'    <caption>                                                                                                                          '+
'        TBI Raw Analyses Process                                                                                                       '+
'    </caption>                                                                                                                         '+
'    <tbody>                                                                                                                            '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">&nbsp;</td>                                                                                    '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">                                                                                               '+
'            <div align="center" style="width: 80%;">                                                                                   '+
'                <h3>Title goes here</h3>                                                                                               '+
'                <p>                                                                                                                    '+
'                Type the text here                                                                                                     '+
'                </p>                                                                                                                   '+
'            </div>                                                                                                                     '+
'        </td>                                                                                                                          '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">&nbsp;</td>                                                                                    '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">                                                                                               '+
'            <div align="center" style="width: 80%;">                                                                                   '+
'                <h3>Title goes here</h3>                                                                                               '+
'                <p>                                                                                                                    '+
'                Type the text here                                                                                                     '+
'                </p>                                                                                                                   '+
'            </div>                                                                                                                     '+
'        </td>                                                                                                                          '+
'        </td>                                                                                                                          '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">&nbsp;</td>                                                                                    '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">&nbsp;</td>                                                                                    '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">                                                                                               '+
'            <div align="center" style="width: 80%;">                                                                                   '+
'                <h3>Title goes here</h3>                                                                                               '+
'                <p>                                                                                                                    '+
'                Type the text here                                                                                                     '+
'                </p>                                                                                                                   '+
'            </div>                                                                                                                     '+
'        </td>                                                                                                                          '+
'        </td>                                                                                                                          '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">&nbsp;</td>                                                                                    '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">&nbsp;</td>                                                                                    '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">                                                                                               '+
'            <table align="center" border="1" cellpadding="1" cellspacing="1" style="width: 500px;">                                    '+
'                <tbody>                                                                                                                '+
'                <tr>                                                                                                                   '+
'                    <td align="center">&nbsp;</td>                                                                                                    '+
'                    <td align="center">&nbsp;</td>                                                                                                    '+
'                </tr>                                                                                                                  '+
'                <tr>                                                                                                                   '+
'                    <td align="center">                                                                                                               '+
'                        <div align="center" style="width: 80%;">                                                                       '+
'                            <h3>Title goes here</h3>                                                                                   '+
'                            <p>                                                                                                        '+
'                            Type the text here                                                                                         '+
'                            </p>                                                                                                       '+
'                        </div>                                                                                                         '+
'                    </td>                                                                                                              '+
'        </td>                                                                                                                          '+
'                    <td align="center">                                                                                                '+
'                        <div align="center" style="width: 80%;">                                                                       '+
'                            <h3>Title goes here</h3>                                                                                   '+
'                            <p>                                                                                                        '+
'                            Type the text here                                                                                         '+
'                            </p>                                                                                                       '+
'                        </div>                                                                                                         '+
'                    </td>                                                                                                              '+
'                    </td>                                                                                                              '+
'                </tr>                                                                                                                  '+
'                <tr>                                                                                                                   '+
'                    <td align="center">&nbsp;</td>                                                                                                    '+
'                    <td align="center">&nbsp;</td>                                                                                                    '+
'                </tr>                                                                                                                  '+
'                <tr>                                                                                                                   '+
'                    <td align="center">                                                                                                               '+
'                        <div align="center" style="width: 80%;">                                                                       '+
'                            <h3>Title goes here</h3>                                                                                   '+
'                            <p>                                                                                                        '+
'                            Type the text here                                                                                         '+
'                            </p>                                                                                                       '+
'                        </div>                                                                                                         '+
'                    </td>                                                                                                              '+
'                    </td>                                                                                                              '+
'                    <td align="center">                                                                                                               '+
'                        <div align="center" style="width: 80%;">                                                                       '+
'                            <h3>Title goes here</h3>                                                                                   '+
'                            <p>                                                                                                        '+
'                            Type the text here                                                                                         '+
'                            </p>                                                                                                       '+
'                        </div>                                                                                                         '+
'                    </td>                                                                                                              '+
'                    </td>                                                                                                              '+
'                </tr>                                                                                                                  '+
'                <tr>                                                                                                                   '+
'                    <td align="center">&nbsp;</td>                                                                                                    '+
'                    <td align="center">&nbsp;</td>                                                                                                    '+
'                </tr>                                                                                                                  '+
'                <tr>                                                                                                                   '+
'                    <td align="center">                                                                                                               '+
'                        <div align="center" style="width: 80%;">                                                                       '+
'                            <h3>Title goes here</h3>                                                                                   '+
'                            <p>                                                                                                        '+
'                            Type the text here                                                                                         '+
'                            </p>                                                                                                       '+
'                        </div>                                                                                                         '+
'                    </td>                                                                                                              '+
'                    </td>                                                                                                              '+
'                    <td align="center">                                                                                                               '+
'                        <div align="center" style="width: 80%;">                                                                       '+
'                            <h3>Title goes here</h3>                                                                                   '+
'                            <p>                                                                                                        '+
'                            Type the text here                                                                                         '+
'                            </p>                                                                                                       '+
'                        </div>                                                                                                         '+
'                    </td>                                                                                                              '+
'                    </td>                                                                                                              '+
'                </tr>                                                                                                                  '+
'                <tr>                                                                                                                   '+
'                    <td align="center">&nbsp;</td>                                                                                                    '+
'                    <td align="center">&nbsp;</td>                                                                                                    '+
'                </tr>                                                                                                                  '+
'    </tbody>                                                                                                                           '+
'            </table>                                                                                                                   '+
'        </td>                                                                                                                          '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">&nbsp;</td>                                                                                    '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td style="text-align: center;">&nbsp;</td>                                                                                    '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    <tr>                                                                                                                               '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'        <td align="center">&nbsp;</td>                                                                                                                '+
'    </tr>                                                                                                                              '+
'    </tbody>                                                                                                                           '+
'</table>                                                                                                                               '+
'<p>                                                                                                                                    '+
'&nbsp;                                                                                                                                 '+
'</p>                                                                                                                                   '+
' '


}




]});





