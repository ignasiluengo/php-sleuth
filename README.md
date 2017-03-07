# php-sleuth
Distributed tracing for microservices

=== Terminology

Spring Cloud Sleuth borrows http://research.google.com/pubs/pub36356.html[Dapper's] terminology.

*Span:* The basic unit of work. For example, sending an RPC is a new span, as is sending a response to an
RPC. Span's are identified by a unique 64-bit ID for the span and another 64-bit ID for the trace the span
is a part of.  Spans also have other data, such as descriptions, timestamped events, key-value
annotations (tags), the ID of the span that caused them, and process ID's (normally IP address).

Spans are started and stopped, and they keep track of their timing information.  Once you create a
span, you must stop it at some point in the future.

TIP: The initial span that starts a trace is called a `root span`. The value of span id
of that span is equal to trace id.

*Trace:* A set of spans forming a tree-like structure.  For example, if you are running a distributed
big-data store, a trace might be formed by a put request.

*Annotation:*  is used to record existence of an event in time. Some of the core annotations used to define
the start and stop of a request are:

    - *cs* - Client Sent - The client has made a request. This annotation depicts the start of the span.
    - *sr* - Server Received -  The server side got the request and will start processing it.
    If one subtracts the cs timestamp from this timestamp one will receive the network latency.
    - *ss* - Server Sent -  Annotated upon completion of request processing (when the response
    got sent back to the client). If one subtracts the sr timestamp from this timestamp one
    will receive the time needed by the server side to process the request.
    - *cr* - Client Received - Signifies the end of the span. The client has successfully received the
    response from the server side. If one subtracts the cs timestamp from this timestamp one
    will receive the whole time needed by the client to receive the response from the server.

Visualization of what *Span* and *Trace* will look in a system together with the Zipkin annotations:

image::https://raw.githubusercontent.com/spring-cloud/spring-cloud-sleuth/{branch}/docs/src/main/asciidoc/images/trace-id.png[Trace Info propagation]

Each color of a note signifies a span (7 spans - from *A* to *G*). If you have such information in the note:

[source]
Trace Id = X
Span Id = D
Client Sent

That means that the current span has *Trace-Id* set to *X*, *Span-Id* set to *D*. It also has emitted
 *Client Sent* event.

This is how the visualization of the parent / child relationship of spans would look like:

image::https://raw.githubusercontent.com/spring-cloud/spring-cloud-sleuth/{branch}/docs/src/main/asciidoc/images/parents.png[Parent child relationship]

=== Purpose

In the following sections the example from the image above will be taken into consideration.
