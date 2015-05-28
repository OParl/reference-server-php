<div class="row">
    <div class="col-xs-12">
        <p>
            Zur Einschränkung der ausgegebenen Daten bietet die OParl API die
            folgende Parametersyntax an:
        </p>
        <pre><code class="language-bash">@include ('api.examples.http_parameters')</code></pre>
        <dl class="dl-horizontal">
            <dt>format</dt>
            <dd>
                Der <code>format</code>-Parameter gibt das Ausgabeformat an. Weitere Informationen
                dazu finden sich im Tab <a href="#access" data-toggle="tab" aria-controls="access">Zugriff</a>.
            </dd>
            <dt>where</dt>
            <dd>
                Der <code>where</code>-Parameter ermöglicht das Filtern der Ausgabe von Listen.
                Er hat keine Wirkung auf die Ausgabe von einzelnen Entities.
            </dd>
            <dt>limit</dt>
            <dd>
                Mit dem <code>limit</code>-Parameter lässt sich die Anzahl von ausgegebenen Listenelementen
                beschränken. Der Parameter funktioniert – ebenso wie <code>where</code> nur
                auf Listenanfragen und hat keine Wirkung, wenn einzelne Entities abgefragt werden.

                <h3>Syntax</h3>
            </dd>
        </dl>

    </div>
</div>