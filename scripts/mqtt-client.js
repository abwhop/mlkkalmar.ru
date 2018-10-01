var MqttClient=function(e){function n(){c.connected=!1,c.reconnect?setTimeout(function(){c.unbind("disconnect",n),c.connect()},c.reconnect):c.emitter.trigger("offline")}var t=Array.prototype.slice,i=function(e){return JSON.parse(JSON.stringify(e))},s=function(e,n,t,i){var s=new Paho.MQTT.Message(n);return s.destinationName=e,s.qos=Number(t)||0,s.retained=!!i,s},c=this;return c.connected=!1,c.broker=i({host:e.host,port:Number(e.port),clientId:e.clientId||"client-"+Math.random().toString(36).slice(-6)}),c.options=i({timeout:Number(e.timeout)||10,keepAliveInterval:Number(e.keepalive)||30,mqttVersion:e.mqttVersion||void 0,userName:e.username||void 0,password:e.password||void 0,useSSL:void 0!==e.ssl?e.ssl:!1,cleanSession:void 0!==e.clean?e.clean:!0,willMessage:e.will&&e.will.topic.length?e.will:void 0}),c.reconnect=e.reconnect,c.emitter={events:{},bind:function(e,n){return c.emitter.events[e]=c.emitter.events[e]||[],c.emitter.events[e].push(n),c},unbind:function(e,n){return e in c.emitter.events&&c.emitter.events[e].splice(c.emitter.events[e].indexOf(n),1),c},trigger:function(e){if(e in c.emitter.events)for(var n=0;n<c.emitter.events[e].length;++n)try{c.emitter.events[e][n].apply(c,t.call(arguments,1))}catch(e){setTimeout(function(){throw e})}}},c.on=c.emitter.bind,c.bind=c.emitter.bind,c.unbind=c.emitter.unbind,c.once=function(e,n){return c.on(e,function i(){n.apply(c,t.call(arguments)),c.unbind(e,i)}),c},c.convertTopic=function(e){return new RegExp("^"+e.replace(/\+/g,"[^/]+").replace(/#/g,".+")+"$")},c.messages={func:[],count:function(e){return c.messages.func.reduce(function(n,t){return n+(t.topic===e)},0)},bind:function(e,n,t,i){return 2===arguments.length&&"function"==typeof n&&(t=n,i=t),t.topic=e,t.re=c.convertTopic(e),t.qos=Number(n)||0,c.messages.func.push(t),i!==!0&&1!==c.messages.count(e)||c.subscribe(e,n),c},unbind:function(e,n){var t=c.messages.func.indexOf(e);return t>-1&&(c.messages.func.splice(t,1),(n===!0||c.messages.count(e.topic)<1)&&c.unsubscribe(e.topic)),c},trigger:function(e){var n=t.call(arguments,1);c.messages.func.forEach(function(t){t.re.test(e)&&t.apply(c,n)})}},c.messages.on=c.messages.bind,c.on("message",c.messages.trigger),c.client=new Paho.MQTT.Client(c.broker.host,c.broker.port,c.broker.clientId),c.client.onConnectionLost=c.emitter.trigger.bind(c,"disconnect"),c.messageCache=[],c.client.onMessageDelivered=function(e){c.messageCache.indexOf(e)>=0&&c.messageCache.splice(c.messageCache.indexOf(e))[0].callback()},c.client.onMessageArrived=function(e){var n;try{n=e.payloadString}catch(e){}c.emitter.trigger("message",e.destinationName,n||e.payloadBytes,{topic:e.destinationName,qos:e.qos,retained:e.retained,payload:e.payloadBytes,duplicate:e.duplicate})},c.connect=function(){c.once("connect",function(){c.connected=!0}),c.once("disconnect",n);var e=i(c.options);return e.onSuccess=c.emitter.trigger.bind(c,"connect"),e.onFailure=c.emitter.trigger.bind(c,"disconnect"),e.willMessage&&(e.willMessage=s(e.willMessage.topic,e.willMessage.payload,e.willMessage.qos,e.willMessage.retain)),c.client.connect(e),c.emitter.trigger("connecting"),c},c.disconnect=function(){c.unbind("disconnect",n),c.client.disconnect(),c.emitter.trigger("disconnect"),c.emitter.trigger("offline")},c.subscribe=function(e,n,t){2===arguments.length&&"function"==typeof arguments[1]&&(t=n),c.client.subscribe(e,t?{qos:Number(n)||0,timeout:15,onSuccess:function(e){t.call(c,void 0,e.grantedQos[0])},onFailure:t.bind(c)}:{})},c.unsubscribe=function(e,n){c.client.unsubscribe(e,n?{timeout:15,onSuccess:n.bind(c,void 0),onFailure:n.bind(c)}:{})},c.publish=function(e,n,t,i){var o=s(e,n,t&&t.qos,t&&t.retain);i&&(o.qos<1?setTimeout(i):(o.callback=i,c.messageCache.push(o))),c.client.send(o)},c};